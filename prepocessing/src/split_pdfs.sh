#!/bin/sh

# loop over all files in pdf dir
# and split them with pdftk
# $ sudo snap install pdftk

for file in pdf/*
do
    #echo $file
    # cut the name to create a foldername
    fbname=$(basename "$file" | cut -d. -f1)
    echo "$fbname"
    output_folder="splitted/$fbname"
    mkdir -p $output_folder
    # the pdfs will be splitted and giving a number
    mask="$output_folder/$fbname""_Page_%03.pdf"	
    pdftk $file burst output $mask 
done
