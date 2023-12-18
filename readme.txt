Jag la upp projektet med att index.php är vår main sida. Där ska allt va i resultatet.

Sen gjorde jag simpel mock-up version av bokningsformuläret i tests mappen på form.php.

_functions.php är bara något jag importerar från med require().

admin.php är en sida där man kan logga in och se vilka orders som är lagda.

dbsetup innehåller en .bat fil för att skapa databaserna så alla slipper skriva SQL setup commandona.

Användarnamn för admin är just nu "test"
Lösen för admin är just nu "test"

cb1: Meny
cb2: Book

The php _functions.php file will return "?ret-msg=KeepTab:<tabid>:<msg>" if tab should be kept, examples:

| URL params                            | Tab react:   |Msg:|
-------------------------------------------------------------
| "?ret-msg=Hi"                         | no tabs open | Hi |
-------------------------------------------------------------
| "?ret-msg=KeepTab:cb1:Hi"             | cb1 open     | Hi |
-------------------------------------------------------------
| "?ret-msg=KeepTab:cb2:Hi"             | cb2 open     | Hi |
-------------------------------------------------------------
| "?ret-msg=KeepTab:cb2:KeepTab:cb1:Hi" | all open     | Hi |
-------------------------------------------------------------