from pdf2image import convert_from_path
import pytesseract
import csv

pytesseract.pytesseract.tesseract_cmd = r'C:\Program Files\Tesseract-OCR\tesseract.exe'


image = convert_from_path("game.pdf")
pdf_image_text= pytesseract.image_to_string(image[0], lang='eng', config='--psm 6')


def format_to_csv(ocr_text, csv_file_path):
    lines = ocr_text.strip().split('\n')
    player_line = lines[0].strip()
    players = player_line.split(" vs ")

    csv_data = []
    csv_data.append(["Info", "Player 1", "Player 2"])
    csv_data.append(["", players[0], players[1]])

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

    with open(csv_file_path, 'w') as csv_file:
        writer = csv.writer(csv_file)
        writer.writerows(csv_data)

ocr_text = pdf_image_text
csv_file_path = 'output.csv'

format_to_csv(ocr_text, csv_file_path)
