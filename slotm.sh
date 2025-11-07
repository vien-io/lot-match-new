#!/bin/bash

# Change to project folder
cd ~/lot-match-new || exit

# Open npm dev server in a new terminal
gnome-terminal -- bash -c "npm run dev; exec bash"

# Open Laravel queue worker in a new terminal
gnome-terminal -- bash -c "php artisan queue:work; exec bash"

# Open VS Code in the current terminal
code .
