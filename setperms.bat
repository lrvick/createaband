@ECHO OFF

REM	This command grants Permission level "Change" to the "Everyone" group.
REM	Other permissions are left in place.  This command acts on all files
REM	in the "startdata" data folder and all subdirectories.

cacls testpak/data /T /E /C /P Everyone:C
attrib -R testpak/data/*.* /S /D

