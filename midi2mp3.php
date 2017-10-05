<?

$midi_file='claude.mid';

$linux_command='sh midi2mp3.sh '.$midi_file;

$output=shell_exec($linux_command);

print "<P>".$output;

?>