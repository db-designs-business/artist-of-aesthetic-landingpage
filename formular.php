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
 * 2. $empfaenger unten prüfen.
 * 3. $absender MUSS eine Adresse der eigenen Domain sein, sonst stufen
 *    viele Mailserver die Nachricht als Fälschung ein (SPF/DMARC).
 *    Die Adresse der Besucherin steht im Reply-To, damit die Antwort
 *    direkt an sie geht.
 * 4. Auf GitHub Pages läuft diese Datei nicht – dort gibt es kein PHP.
 *    Das Formular zeigt dann den Ersatzweg mit Telefonnummer an.
 * ------------------------------------------------------------------
 */

$empfaenger = 'info@artist-of-aesthetic.de';
$absender   = 'info@artist-of-aesthetic.de';
$betreff    = 'Terminanfrage über die Website';

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
$behandlung  = feld('behandlung');
$wunsch      = feld('wunsch');
$nachricht   = feld('nachricht');
$neukundin   = feld('neu') !== '';
$datenschutz = feld('datenschutz') !== '';

$fehler = array();

if ($name === '' || mb_strlen($name) < 2) {
    $fehler[] = 'Name fehlt oder ist zu kurz.';
}
if (preg_replace('/[^0-9]/', '', $telefon) === '' ||
    strlen(preg_replace('/[^0-9]/', '', $telefon)) < 7) {
    $fehler[] = 'Telefonnummer fehlt oder ist unvollständig.';
}
if ($email !== '' && !filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $fehler[] = 'E-Mail-Adresse ist ungültig.';
}
if ($behandlung === '') {
    $fehler[] = 'Wunschbehandlung fehlt.';
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

// ---------------------------------------------------------------- Nachricht
$zeilen = array(
    'Neue Terminanfrage über die Website',
    str_repeat('=', 40),
    '',
    'Name:              ' . $name,
    'Telefon:           ' . $telefon,
    'E-Mail:            ' . ($email !== '' ? $email : '– nicht angegeben –'),
    'Wunschbehandlung:  ' . $behandlung,
    'Wunschzeitraum:    ' . ($wunsch !== '' ? $wunsch : '– offen –'),
);

if ($neukundin) {
    $zeilen[] = 'Neukundin:         ja, 20 % Rabatt vormerken';
}

$zeilen[] = '';
$zeilen[] = 'Nachricht:';
$zeilen[] = $nachricht !== '' ? $nachricht : '– keine –';
$zeilen[] = '';
$zeilen[] = str_repeat('-', 40);
$zeilen[] = 'Datenschutzerklärung akzeptiert am '
    . date('d.m.Y \u\m H:i') . ' Uhr';
$zeilen[] = 'Abgesendet von: ' . (isset($_SERVER['HTTP_REFERER'])
    ? sauber($_SERVER['HTTP_REFERER']) : 'unbekannt');

$text = implode("\n", $zeilen);

$kopf = array(
    'From: Artist of Aesthetic Website <' . $absender . '>',
    'Content-Type: text/plain; charset=UTF-8',
    'Content-Transfer-Encoding: 8bit',
    'X-Mailer: PHP/' . phpversion(),
);
if ($email !== '') {
    $kopf[] = 'Reply-To: ' . sauber($name) . ' <' . sauber($email) . '>';
}

$betreffKodiert = '=?UTF-8?B?' . base64_encode($betreff . ' – ' . $name) . '?=';

$gesendet = mail(
    $empfaenger,
    $betreffKodiert,
    $text,
    implode("\r\n", $kopf),
    '-f' . $absender
);

if (!$gesendet) {
    antwort(
        false,
        'Die Nachricht konnte gerade nicht versendet werden. '
        . 'Bitte ruf uns kurz an unter 0176 76333562.',
        500
    );
}

antwort(true, 'Danke! Deine Anfrage ist eingegangen.');
