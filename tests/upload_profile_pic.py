from flask import Flask, request, redirect, url_for, render_template
import pymysql

app = Flask(__name__)
app.config['UPLOAD_FOLDER'] = 'uploads/'

# Configure MySQL connection
db = pymysql.connect(
    host='localhost',
    user='root',
    password='root',
    database='event_app'
)

@app.route('/')
def index():
    return render_template('index.html')

@app.route('/upload', methods=['POST'])
def upload_image():
    if 'file' not in request.files:
        return 'No file part'
    file = request.files['file']
    if file.filename == '':
        return 'No selected file'
    if file:
        filename = secure_filename(file.filename)
        file_path = os.path.join(app.config['UPLOAD_FOLDER'], filename)
        file.save(file_path)
        
        # Update the database entry
        cursor = db.cursor()
        sql = "UPDATE users SET profile_image = %s WHERE id = %s"
        cursor.execute(sql, (file_path, user_id))
        db.commit()
        cursor.close()
        
        return redirect(url_for('index'))

if __name__ == '__main__':
    app.run(debug=True)