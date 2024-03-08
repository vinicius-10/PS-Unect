from datetime import datetime, timezone, timedelta
import mysql.connector, os, requests

con = mysql.connector.connect(host='localhost', database='arduino',user='root', password='')

 


id_execute=0
while True:
    date= datetime.now()
    fuso = timedelta(hours=-3) 
    fuso = timezone(fuso)
    date = date.astimezone(fuso)
    hour = date.strftime('%H:%M:00')

    consuta_sql="select ac.id_aparelho_fk, ac.action, ac.repeat_action, ac.starting_day, ac.last_day, ac.weekly, a.relay, ac.id_action from automatic_action ac, aparelho a where id_aparelho_fk=id_aparelho and execute=1 and hour='"+hour+"'"
    cursor=con.cursor()
    cursor.execute(consuta_sql)
    linha=cursor.fetchall()
    cancel=''
    control=0
    print(hour)

    for linha in linha: 
        print('dentro')
        
        id_aparelho=str(linha[0])
        repeat=str(linha[2])
        action=str(linha[1])
        relay=str(linha[6])
        id_action=str(linha[7])
        day = date.strftime('%Y-%m-%d')
        
        
        if (id_action!=id_execute):
            print('executa')
            id_execute=id_action
        
            if(repeat =='period'):       
                start_day=str(linha[3])
                end_day=str(linha[4])
                
                
                if (start_day<=day and end_day >= day):
                    
                    #requests.get('192.168.0.103/?relay'+relay+'='+action)
                    control=1
                    
                    if(end_day == day):
                        
                        cancel= "UPDATE automatic_action set execute=0 where id_action="+ id_action
                        
                        
                        
            elif(repeat =='weekly'):       
                weekly=str(linha[5])
                weekly =list(weekly)
                
                weekday = str(int(date.strftime('%w'))+1)
                
                for c in weekly:
                    if(c == weekday):
                        #requests.get('192.168.0.103/?relay'+relay+'='+action)
                        control=1
            
            elif(repeat=='no'):        
                start_day=str(linha[3])
                
                #requests.get('192.168.0.103/?relay'+relay+'='+action)
                cancel= "UPDATE automatic_action set execute=0 where id_action="+ id_action
                control=1
                
            cursor=con.cursor()
            cursor.execute(cancel)
            con.commit()
            if(control==1):
        
                consuta_sql="select email from usuario where permissao=1 "
                cursor=con.cursor()
                cursor.execute(consuta_sql)
                linha=cursor.fetchall()
                
                if(action=='on'):
                    
                    command='ligado'
                else:
                    command='desligado'

                for linha in linha:
                    email_=str(linha[0])
                    if(email_!='None'):
                        os.system("python notifica.py "+id_aparelho +" "+email_+" "+command+" sistem")
                    

                if(action=='on'):
                    
                    action='1'
                else:
                    action='0'
                
                register="INSERT into registro values('null','1','"+id_aparelho+"','"+action+"','"+hour+"','"+day+"')"
                cursor = con.cursor()
                cursor.execute(register)
                con.commit()