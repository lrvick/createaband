#!/bin/sh

echo Setting permissions...

chmod 755 testpak/*.cgi
chmod 755 testpak/*.pl
chmod 777 testpak/data
chmod -R 766 testpak/data/*
