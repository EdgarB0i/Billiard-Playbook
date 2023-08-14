from pdf2image import convert_from_path
import pytesseract
import csv
import os
from datetime import datetime

# Set the Tesseract executable path
pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'

def format_to_csv(ocr_text, csv_file_path):
    lines = ocr_text.strip().split('\n')
    date_preparation=lines[1]
    date=date_preparation[:10]
    # Converting the date to DD-MM-YYYY format
    date_obj = datetime.strptime(date, '%Y-%m-%d')
    formatted_date = date_obj.strftime('%d-%m-%Y')
    
    
    player_line = lines[0].strip()
    players = player_line.split(" vs ")
    print("Players:", players)


    csv_data = []
    csv_data.append(["Info", "Player 1", "Player 2","Date"])
    csv_data.append(["", players[0], players[1],formatted_date])

    for line in lines[1:]:
        if line.startswith(('|', ' ', '\n', 'k')) or line == '':
            continue
        if ':' in line:
            info = line.split(":")
            key = info[0].strip()
            values = info[1].strip().split("|")
            value1 = values[0].strip()
            value2 = values[1].strip() if len(values) > 1 else ''
            csv_data.append([key, value1, value2])

    with open(csv_file_path, 'w', newline='', encoding='utf-8') as csv_file:
        writer = csv.writer(csv_file)
        writer.writerows(csv_data)

# Get the path to the directory where the PDF files are stored
pdf_directory = 'D:/Projects/Billiard pdf to csv/storage/app/uploads/'

# Find the latest "to-be-converted" PDF file
pdf_files = [f for f in os.listdir(pdf_directory) if f.startswith('to-be-converted-')]
latest_pdf = max(pdf_files, key=lambda x: int(x.split('-')[3].split('.')[0]))

# Construct the full paths for the input PDF and output CSV files
pdf_file_path = os.path.join(pdf_directory, latest_pdf)

# Convert PDF to image and perform OCR
pdf_image_text = ""
try:
    images = convert_from_path(pdf_file_path)
    for image in images:
        pdf_image_text += pytesseract.image_to_string(image, lang='eng', config='--psm 6')
except Exception as e:
    print("Error:", e)

# Specify output CSV path
csv_file_path = os.path.join(pdf_directory, 'converted-' + latest_pdf.split('-')[3].split('.')[0] + '.csv')

# Call the formatting function
format_to_csv(pdf_image_text, csv_file_path)
