import os
from pdf2image import convert_from_path
import pytesseract
import csv
from datetime import datetime

pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'

def convert_pdf_to_text(pdf_path):
    # Convert PDF to images
    image = convert_from_path(pdf_path)
    pdf_image_text = pytesseract.image_to_string(image[0], lang='eng', config='--psm 6')
    return pdf_image_text

def format_to_csv(ocr_text, csv_file_path):
    lines = ocr_text.strip().split('\n')
    player_line = lines[0].strip()
    players = player_line.split(" vs ")
    date_preparation=lines[1]
    date=date_preparation[:10]
    # Converting the date to DD-MM-YYYY format
    date_obj = datetime.strptime(date, '%Y-%m-%d')
    formatted_date = date_obj.strftime('%d-%m-%Y')

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

# Specify the parent directory path
parent_dir = r'D:\Projects\Billiard pdf to csv\storage\app\uploads'

# Find the latest "to-be-converted" folder
to_be_converted_folders = [f for f in os.listdir(parent_dir) if f.startswith('to-be-converted-') and not f.endswith('.zip') and not f.endswith('.pdf')]
latest_to_be_converted = max(to_be_converted_folders)

# Construct the full path for the "to-be-converted-largest number" folder
pdfs_dir = os.path.join(parent_dir, latest_to_be_converted)


output_dir = pdfs_dir  # Output directory is the same as input directory

# Get list of all PDFs
pdf_files = [f for f in os.listdir(output_dir) if f.endswith('.pdf')]

# Convert each PDF to text and format to CSV
for pdf_file in pdf_files:
    pdf_path = os.path.join(pdfs_dir, pdf_file)
    ocr_text = convert_pdf_to_text(pdf_path)

    csv_file_name = os.path.splitext(pdf_file)[0] + '.csv'
    csv_file_path = os.path.join(output_dir, csv_file_name)

    format_to_csv(ocr_text, csv_file_path)
