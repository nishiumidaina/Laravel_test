import subprocess
import tourch
import mysql.connector


# コネクション作成
conn = mysql.connector.connect(
    host='127.0.0.1',
    port='3306',
    user='0000',
    password='0000',
    database='gisproject'
)
# 接続状況確認
print(conn.is_connected())
cur = conn.cursor(buffered=True)
cur.execute("SELECT id, name, status, url FROM spots")
db_lis = cur.fetchall()
print(db_lis[0])
# DB操作終了
cur.close()


#状態判定用のグローバル変数
for i in range(len(db_lis)):
    url = db_lis[i][3]
    if db_lis[i][2] == 'Start':
        cur = conn.cursor(buffered=True)
        sql = ("UPDATE spots SET status = %s WHERE id = %s")
        param = ('Run',db_lis[i][0])
        cur.execute(sql,param)
        conn.commit()
        cur.close()        
        N = subprocess.Popen('python Python/yolov5_02/main.py --source "%s" --class 0' % (url),shell=True)
        #BDの値を変更

