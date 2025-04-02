from flask import Flask, request
from datetime import datetime

app = Flask(__name__)

@app.route('/notify', methods=['GET'])
def notify():
    # Debug/print statement with timestamp
    now = datetime.now().strftime("%Y-%m-%d %H:%M:%S")
    print(f"[DEBUG {now}] /notify endpoint was called from {request.remote_addr}")
    
    # Print purchase message
    print("Item purchased")
    return "Notification received", 200

if __name__ == '__main__':
    app.run(host='0.0.0.0', port=2100, debug=True)
