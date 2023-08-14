from flask import Flask, render_template
import pandas as pd

app = Flask(__name__)

@app.route("/")
def show_table():
    csv_file_path = 'output.csv'
    data = pd.read_csv(csv_file_path)
    data = data[data[['Player 1', 'Player 2']].notna().any(axis=1)]  # Only drop a row if both 'Player 1' and 'Player 2' are NaN
    data = data.fillna('')  # replace NaN with empty string
    table_html = data.to_html(classes='data', index=False)  # set index=False to not display the DataFrame's index in the HTML table
    return render_template('table.html', table_html=table_html, title='output.csv')

if __name__ == "__main__":
    app.run(debug=True)
