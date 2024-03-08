import mysql.connector, smtplib, sys, email.message

con = mysql.connector.connect(host='localhost', database='arduino',user='root', password='')

aparelho = str(sys.argv[1])
email_usuario  = str(sys.argv[2])
acao = str(sys.argv[3])
adm=None
adm = str(sys.argv[4])


'''
aparelho = '4'
email_usuario  = 'vs211570@gmail.com'
acao ='Desligar'
'''
consuta_sql=" SELECT nome_aparelho from aparelho where id_aparelho="+ aparelho 
cursor=con.cursor()
cursor.execute(consuta_sql)
linha=cursor.fetchall()
for linha in linha:
    nome_aprelho=str(linha[0])


if(adm == 'sistem'):

    corpo_email = f"""
    <p>Ação Automatica registrada.</p><br>
    <p>O aparelho {nome_aprelho} foi {acao}</p>
        """
else:
    corpo_email = f"""
    <p>Nova atividade.</p><br>
    <p>Uma ação foi realizada pela sua conta </p>
    <p>O aparelho {nome_aprelho} foi {acao}</p>
        """
        
msg = email.message.Message()
msg['Subject'] = "Nova atividade na conta"
msg['From'] = 'st177608@gmail.com'
msg['To'] = email_usuario 
password = 'yxptxpmvqzkbcaxa' 
msg.add_header('Content-Type', 'text/html')
msg.set_payload(corpo_email )

s = smtplib.SMTP('smtp.gmail.com: 587')
s.starttls()
# Login Credentials for sending the mail
s.login(msg['From'], password)
s.sendmail(msg['From'], [msg['To']], msg.as_string().encode('utf-8'))


