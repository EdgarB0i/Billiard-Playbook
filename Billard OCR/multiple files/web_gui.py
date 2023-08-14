from flask import Flask, render_template
import pandas as pd
import os

app = Flask(__name__)

@app.route("/")
def show_tables():
    output_dir = 'outputs'
    csv_files = [f for f in os.listdir(output_dir) if f.endswith('.csv')]

    tables = []
    titles = []
    for csv_file in csv_files:
        csv_file_path = os.path.join(output_dir, csv_file)
        data = pd.read_csv(csv_file_path)
        data = data[data[['Player 1', 'Player 2']].notna().any(axis=1)]  # Only drop a row if both 'Player 1' and 'Player 2' are NaN
        data = data.fillna('')  # replace NaN with empty string
        tables.append(data.to_html(classes='data', index=False))  # set index=False to not display the DataFrame's index in the HTML table
        titles.append(csv_file)

    table_title_pairs = zip(tables, titles)
    return render_template('table.html', table_title_pairs=table_title_pairs)

if __name__ == "__main__":
    app.run(debug=True)
