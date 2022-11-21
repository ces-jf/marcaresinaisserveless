import json
from db import db_helper
import boto3
import os

def lambda_handler(event=None, context=None):
    request = get_request(event=event)
    if request is None:
        return {
            "statusCode": 400,
            "body": {
                "message": "Error"
            }
        }
    
    dbHelper = db_helper.DBHelper()
    sns = boto3.client('sns')
    snsarn = os.environ['DEADLETTER_SNS_TOPIC']    
    try:
        dbHelper.delete_person(request=request)

    except Exception as e:  
        print(e)      
        request_json = json.dumps(request)
        response = sns.publish(
            TargetArn=snsarn,
            Message=str(request_json)            
        )
        return {
            "statusCode": 500,
            "body": {
                "mensagem": "Erro ao processar: {e}",
                "sns" : response['MessageId']
            }
        }

    return {
        "statusCode": 200,
        "body": json.dumps(
            {
                "Registros Deletados": "OK",
            }
        ),
    }

def get_request(event) -> str:
    if "Records" in event:
        body = event['Records'][0]['body']
        event = json.loads(body)
    return event

