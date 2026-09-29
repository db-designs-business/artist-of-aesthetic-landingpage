<?php
/**
 * Versand der Terminanfragen.
 *
 * Nimmt das Formular per POST entgegen, prüft die Angaben noch einmal
 * serverseitig und schickt eine E-Mail. Es wird nichts gespeichert und
 * nichts an Dritte weitergegeben – die Daten gehen nur an das Postfach
 * des Studios.
 *
 * ------------------------------------------------------------------
 * EINRICHTUNG
 * ------------------------------------------------------------------
 * 1. Datei ins Wurzelverzeichnis der Website legen (neben index.html).
 * 2. $empfaenger steht auf info@artist-of-aesthetic.de. Zum Testen
 *    vorübergehend eine andere Adresse eintragen und danach
 *    zurücksetzen.
 * 3. $absender MUSS eine Adresse der eigenen Domain sein, sonst stufen
 *    viele Mailserver die Nachricht als Fälschung ein (SPF/DMARC).
 *    Die Adresse der Besucherin steht im Reply-To, damit die Antwort
 *    direkt an sie geht.
 * 4. Die Datei heißt bewusst NICHT kontakt.php: unter /kontakt/ liegt
 *    die Kontaktseite, und Apache könnte beides verwechseln.
 * 5. Auf GitHub Pages läuft diese Datei nicht – dort gibt es kein PHP.
 *    Das Formular zeigt dann den Ersatzweg mit Telefonnummer an.
 * ------------------------------------------------------------------
 */

// Postfach des Studios. Hier laufen die Anfragen auf.
$empfaenger = 'info@artist-of-aesthetic.de';

// MUSS eine Adresse der eigenen Domain sein, sonst stufen viele
// Mailserver die Nachricht als Fälschung ein (SPF/DMARC). Dass
// Empfänger und Absender gleich sind, ist in Ordnung.
$absender = 'info@artist-of-aesthetic.de';

// Für die Fußzeile der E-Mail und die Links darin
$studio   = 'Artist of Aesthetic';
$telefon_studio = '0176 76333562';
$domain   = 'https://artist-of-aesthetic.de';

// ---------------------------------------------------------------- Antwort
header('Content-Type: application/json; charset=utf-8');

function antwort($ok, $meldung, $status = 200)
{
    http_response_code($status);
    echo json_encode(array('ok' => $ok, 'meldung' => $meldung));
    exit;
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    antwort(false, 'Nur POST erlaubt.', 405);
}

// ---------------------------------------------------------------- Spamschutz
// 1. Honigtopf: ein Feld, das im Browser unsichtbar ist. Menschen füllen
//    es nie aus, viele Bots schon. Wir tun so, als sei alles in Ordnung,
//    damit der Bot nicht merkt, dass er erkannt wurde.
if (!empty($_POST['website'])) {
    antwort(true, 'Danke!');
}

// 2. Zeitprüfung: wer das Formular in unter drei Sekunden ausfüllt, ist
//    kein Mensch.
$gestartet = isset($_POST['startzeit']) ? (int) $_POST['startzeit'] : 0;
if ($gestartet > 0 && (time() - $gestartet) < 3) {
    antwort(true, 'Danke!');
}

// ---------------------------------------------------------------- Eingaben
function feld($name)
{
    return isset($_POST[$name]) ? trim((string) $_POST[$name]) : '';
}

$name        = feld('name');
$telefon     = feld('tel');
$email       = feld('email');
$nachricht   = feld('nachricht');
$datenschutz = feld('datenschutz') !== '';

$fehler = array();

if ($name === '' || mb_strlen($name) < 2) {
    $fehler[] = 'Name fehlt oder ist zu kurz.';
}
if (strlen(preg_replace('/[^0-9]/', '', $telefon)) < 7) {
    $fehler[] = 'Telefonnummer fehlt oder ist unvollständig.';
}
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $fehler[] = 'E-Mail-Adresse ist ungültig.';
}
if (!$datenschutz) {
    $fehler[] = 'Zustimmung zur Datenschutzerklärung fehlt.';
}
if ($fehler) {
    antwort(false, implode(' ', $fehler), 422);
}

// Zeilenumbrüche aus Kopfzeilenfeldern entfernen (Header-Injection)
function sauber($wert)
{
    return str_replace(array("\r", "\n", "%0a", "%0d"), '', $wert);
}

// Alles, was in die HTML-Fassung geht, muss maskiert werden – sonst
// könnte jemand über das Nachrichtenfeld eigenes Markup einschleusen.
function h($wert)
{
    return htmlspecialchars($wert, ENT_QUOTES, 'UTF-8');
}

$zeitpunkt = date('d.m.Y') . ' um ' . date('H:i') . ' Uhr';
$herkunft  = isset($_SERVER['HTTP_REFERER']) ? sauber($_SERVER['HTTP_REFERER']) : 'unbekannt';

// Telefonnummer für den Anruf-Link: alles außer Ziffern und + entfernen
$telWaehlbar = preg_replace('/[^0-9+]/', '', $telefon);

// ================================================================
//  TEXTFASSUNG
//  Geht an Postfächer, die kein HTML anzeigen, und an die Vorschau
//  auf der Uhr oder im Sperrbildschirm. Deshalb stehen die wichtigsten
//  Angaben ganz oben.
// ================================================================
$zeilen = array(
    'NEUE TERMINANFRAGE',
    str_repeat('=', 46),
    '',
    'Name:      ' . $name,
    'Telefon:   ' . $telefon,
    'E-Mail:    ' . ($email !== '' ? $email : '– nicht angegeben –'),
    '',
    'Nachricht:',
    $nachricht !== '' ? $nachricht : '– keine –',
    '',
    str_repeat('-', 46),
    'Eingegangen am ' . $zeitpunkt,
    'Datenschutzerklärung wurde beim Absenden bestätigt.',
    'Formular auf: ' . $herkunft,
);
$text = implode("\n", $zeilen);

// ================================================================
//  HTML-FASSUNG
//
//  Bewusst altmodisch gebaut: Tabellen statt Flexbox, Farben direkt
//  am Element statt im Stylesheet. E-Mail-Programme – allen voran
//  Outlook – können modernes CSS nicht. Was hier steht, sieht überall
//  gleich aus.
//
//  Die Telefonnummer ist der größte Text in der Mail und anklickbar:
//  In neun von zehn Fällen ist der Rückruf die Antwort.
// ================================================================
$nachrichtHtml = $nachricht !== ''
    ? nl2br(h($nachricht))
    : '<span style="color:#9a9a9a;">– keine Nachricht hinterlassen –</span>';

$emailZeile = $email !== ''
    ? '<a href="mailto:' . h($email) . '" style="color:#8d4f66;text-decoration:none;">' . h($email) . '</a>'
    : '<span style="color:#9a9a9a;">nicht angegeben</span>';

$html = '<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Neue Terminanfrage</title>
</head>
<body style="margin:0;padding:0;background:#f4eef1;">

<!-- Vorschautext: erscheint in der Übersicht neben dem Betreff -->
<div style="display:none;max-height:0;overflow:hidden;opacity:0;">
  ' . h($name) . ' – ' . h($telefon) . ' – Terminanfrage über die Website
</div>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f4eef1;padding:24px 12px;">
<tr><td align="center">

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:560px;background:#ffffff;border-radius:6px;overflow:hidden;font-family:Helvetica,Arial,sans-serif;">

    <!-- Kopf -->
    <tr>
      <td style="background:#282023;padding:22px 28px;">
        <div style="font-size:11px;letter-spacing:2px;text-transform:uppercase;color:#efd7e5;">Website-Anfrage</div>
        <div style="font-size:21px;color:#ffffff;padding-top:6px;">Neue Terminanfrage</div>
      </td>
    </tr>

    <!-- Rückruf: der wichtigste Block, deshalb ganz oben und groß -->
    <tr>
      <td style="padding:26px 28px 6px;">
        <div style="font-size:11px;letter-spacing:1.6px;text-transform:uppercase;color:#8d4f66;padding-bottom:8px;">Rückruf an</div>
        <div style="font-size:19px;color:#282023;padding-bottom:4px;"><strong>' . h($name) . '</strong></div>
        <div style="font-size:26px;line-height:1.2;">
          <a href="tel:' . h($telWaehlbar) . '" style="color:#8d4f66;text-decoration:none;"><strong>' . h($telefon) . '</strong></a>
        </div>
        <div style="font-size:14px;padding-top:6px;">' . $emailZeile . '</div>
      </td>
    </tr>

    <!-- Nachricht -->
    <tr>
      <td style="padding:22px 28px 0;">
        <div style="border-top:1px solid #ece3e7;font-size:0;line-height:0;padding-bottom:20px;">&nbsp;</div>
        <div style="font-size:11px;letter-spacing:1.6px;text-transform:uppercase;color:#6b6b6b;padding-bottom:8px;">Nachricht</div>
        <div style="background:#faf6f8;border-left:3px solid #efd7e5;padding:14px 16px;font-size:14px;line-height:1.6;color:#282023;">
          ' . $nachrichtHtml . '
        </div>
      </td>
    </tr>

    <!-- Fußzeile -->
    <tr>
      <td style="padding:24px 28px 26px;">
        <div style="border-top:1px solid #ece3e7;padding-top:16px;font-size:12px;line-height:1.7;color:#8a8a8a;">
          Eingegangen am ' . h($zeitpunkt) . '.<br>
          Die Datenschutzerkl&auml;rung wurde beim Absenden best&auml;tigt.<br>
          Gesendet &uuml;ber das Formular auf <a href="' . h($domain) . '" style="color:#8d4f66;text-decoration:none;">artist-of-aesthetic.de</a>.
        </div>
      </td>
    </tr>

  </table>

  <div style="max-width:560px;padding:14px 4px 0;font-family:Helvetica,Arial,sans-serif;font-size:11px;color:#a89aa1;text-align:center;">
    Diese Nachricht wurde automatisch erzeugt. Eine Antwort geht direkt an ' . ($email !== '' ? h($name) : 'das Studio') . '.
  </div>

</td></tr>
</table>

</body>
</html>';

// ================================================================
//  VERSAND
//  multipart/alternative: beide Fassungen in einer Nachricht. Das
//  Postfach zeigt die HTML-Fassung, wenn es kann, sonst den Text.
// ================================================================
$grenze = '=_aoa_' . md5(uniqid('', true));

$kopf = array(
    'MIME-Version: 1.0',
    'From: ' . $studio . ' Website <' . $absender . '>',
    'Content-Type: multipart/alternative; boundary="' . $grenze . '"',
    'X-Mailer: PHP/' . phpversion(),
);
if ($email !== '') {
    $kopf[] = 'Reply-To: ' . sauber($name) . ' <' . sauber($email) . '>';
}

$koerper =
    '--' . $grenze . "\r\n"
    . "Content-Type: text/plain; charset=UTF-8\r\n"
    . "Content-Transfer-Encoding: 8bit\r\n\r\n"
    . $text . "\r\n\r\n"
    . '--' . $grenze . "\r\n"
    . "Content-Type: text/html; charset=UTF-8\r\n"
    . "Content-Transfer-Encoding: 8bit\r\n\r\n"
    . $html . "\r\n\r\n"
    . '--' . $grenze . "--\r\n";

// Betreff mit Namen – so ist die Anfrage schon in der Übersicht
// zuzuordnen, ohne sie zu öffnen.
$betreff = 'Terminanfrage: ' . $name;
$betreffKodiert = '=?UTF-8?B?' . base64_encode($betreff) . '?=';

$gesendet = mail(
    $empfaenger,
    $betreffKodiert,
    $koerper,
    implode("\r\n", $kopf),
    '-f' . $absender
);

if (!$gesendet) {
    antwort(
        false,
        'Die Nachricht konnte gerade nicht versendet werden. '
        . 'Bitte ruf uns kurz an unter ' . $telefon_studio . '.',
        500
    );
}

// ================================================================
//  EINGANGSBESTAETIGUNG AN DIE KUNDIN
//
//  Geht erst raus, wenn die Nachricht ans Studio durch ist. Wenn hier
//  etwas schiefgeht - Tippfehler in der Adresse, volles Postfach -,
//  merkt die Kundin davon nichts: Ihre Anfrage ist ja angekommen, und
//  eine Fehlermeldung an dieser Stelle wuerde nur verunsichern.
//
//  Reply-To zeigt bewusst auf das Studio. Wer auf die Bestaetigung
//  antwortet, landet damit im richtigen Postfach.
// ================================================================
$antwortText = implode("\n", array(
    'Hallo ' . $name . ',',
    '',
    'danke fuer deine Anfrage. Sie ist bei uns angekommen.',
    '',
    'Wir melden uns innerhalb von 24 Stunden bei dir, per Anruf oder',
    'WhatsApp. Falls du am Sonntag geschrieben hast: Das Studio ist',
    'sonntags geschlossen, dann hoerst du am Montag von uns.',
    '',
    ($nachricht !== '' ? "Das hast du uns geschickt:\n" . $nachricht . "\n" : ''),
    'Beim ersten Termin schauen wir uns deine Haut in Ruhe an. Die',
    'Hautanalyse ist kostenlos und verpflichtet dich zu nichts. Erst',
    'danach entscheidest du, ob und was gemacht wird.',
    '',
    'Wenn dir zwischendurch noch etwas einfaellt oder sich etwas',
    'aendert, ruf einfach an: ' . $telefon_studio,
    '',
    'Bis bald',
    'Aylin Acikgoez',
    $studio,
    '',
    str_repeat('-', 46),
    'Schwimmbadstrasse 14, 76646 Bruchsal',
    'Montag bis Samstag, 10:00 bis 18:00 Uhr. Sonntag geschlossen.',
    $absender . ', artist-of-aesthetic.de',
    '',
    'Diese Nachricht wurde automatisch verschickt, weil du das Formular',
    'auf unserer Website ausgefuellt hast. Du kannst direkt darauf',
    'antworten.',
));

$deineNachricht = $nachricht !== ''
    ? '<tr><td style="padding:4px 28px 0;">
         <div style="font-size:11px;letter-spacing:1.6px;text-transform:uppercase;color:#6b6b6b;padding-bottom:8px;">Das hast du uns geschickt</div>
         <div style="background:#faf6f8;border-left:3px solid #efd7e5;padding:14px 16px;font-size:14px;line-height:1.6;color:#282023;">'
      . nl2br(h($nachricht)) . '</div>
       </td></tr>'
    : '';

$antwortHtml = '<!DOCTYPE html>
<html lang="de">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>Deine Anfrage ist da</title>
</head>
<body style="margin:0;padding:0;background:#f4eef1;">

<div style="display:none;max-height:0;overflow:hidden;opacity:0;">
  Wir melden uns innerhalb von 24 Stunden bei dir.
</div>

<table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="background:#f4eef1;padding:24px 12px;">
<tr><td align="center">

  <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0" style="max-width:560px;background:#ffffff;border-radius:6px;overflow:hidden;font-family:Helvetica,Arial,sans-serif;">

    <tr>
      <td style="background:#282023;padding:22px 28px;">
        <div style="font-size:11px;letter-spacing:2px;text-transform:uppercase;color:#efd7e5;">Artist of Aesthetic</div>
        <div style="font-size:21px;color:#ffffff;padding-top:6px;">Deine Anfrage ist da</div>
      </td>
    </tr>

    <tr>
      <td style="padding:26px 28px 0;font-size:15px;line-height:1.65;color:#282023;">
        <p style="margin:0 0 16px;">Hallo <strong>' . h($name) . '</strong>,</p>
        <p style="margin:0 0 16px;">danke f&uuml;r deine Anfrage. Sie ist bei uns angekommen.</p>
        <p style="margin:0 0 16px;">Wir melden uns <strong>innerhalb von 24&nbsp;Stunden</strong> bei dir, per Anruf oder WhatsApp. Falls du am Sonntag geschrieben hast: Das Studio ist sonntags geschlossen, dann h&ouml;rst du am Montag von uns.</p>
      </td>
    </tr>

    ' . $deineNachricht . '

    <tr>
      <td style="padding:18px 28px 0;font-size:15px;line-height:1.65;color:#282023;">
        <p style="margin:0 0 16px;">Beim ersten Termin schauen wir uns deine Haut in Ruhe an. Die Hautanalyse ist kostenlos und verpflichtet dich zu nichts. Erst danach entscheidest du, ob und was gemacht wird.</p>
        <p style="margin:0 0 20px;">Wenn dir zwischendurch noch etwas einf&auml;llt oder sich etwas &auml;ndert, ruf einfach an:
          <a href="tel:+4917676333562" style="color:#8d4f66;text-decoration:none;white-space:nowrap;"><strong>' . h($telefon_studio) . '</strong></a>
        </p>
        <p style="margin:0 0 4px;">Bis bald</p>
        <p style="margin:0;"><strong>Aylin Acikg&ouml;z</strong><br>' . h($studio) . '</p>
      </td>
    </tr>

    <tr>
      <td style="padding:24px 28px 26px;">
        <div style="border-top:1px solid #ece3e7;padding-top:16px;font-size:12px;line-height:1.7;color:#8a8a8a;">
          Schwimmbadstra&szlig;e 14, 76646 Bruchsal<br>
          Montag bis Samstag, 10:00 bis 18:00 Uhr. Sonntag geschlossen.<br>
          <a href="mailto:' . h($absender) . '" style="color:#8d4f66;text-decoration:none;">' . h($absender) . '</a>,
          <a href="' . h($domain) . '" style="color:#8d4f66;text-decoration:none;">artist-of-aesthetic.de</a>
        </div>
      </td>
    </tr>

  </table>

  <div style="max-width:560px;padding:14px 4px 0;font-family:Helvetica,Arial,sans-serif;font-size:11px;line-height:1.6;color:#a89aa1;text-align:center;">
    Diese Nachricht wurde automatisch verschickt, weil du das Formular auf unserer Website ausgef&uuml;llt hast. Du kannst direkt darauf antworten.
  </div>

</td></tr>
</table>

</body>
</html>';

$grenze2 = '=_aoa_' . md5(uniqid('b', true));
$kopf2 = array(
    'MIME-Version: 1.0',
    'From: ' . $studio . ' <' . $absender . '>',
    'Reply-To: ' . $studio . ' <' . $absender . '>',
    'Content-Type: multipart/alternative; boundary="' . $grenze2 . '"',
    'Auto-Submitted: auto-replied',
    'X-Auto-Response-Suppress: All',
    'X-Mailer: PHP/' . phpversion(),
);
$koerper2 =
    '--' . $grenze2 . "\r\n"
    . "Content-Type: text/plain; charset=UTF-8\r\n"
    . "Content-Transfer-Encoding: 8bit\r\n\r\n"
    . $antwortText . "\r\n\r\n"
    . '--' . $grenze2 . "\r\n"
    . "Content-Type: text/html; charset=UTF-8\r\n"
    . "Content-Transfer-Encoding: 8bit\r\n\r\n"
    . $antwortHtml . "\r\n\r\n"
    . '--' . $grenze2 . "--\r\n";

@mail(
    sauber($email),
    '=?UTF-8?B?' . base64_encode('Deine Anfrage ist da, wir melden uns') . '?=',
    $koerper2,
    implode("\r\n", $kopf2),
    '-f' . $absender
);

antwort(true, 'Danke! Deine Anfrage ist eingegangen.');
