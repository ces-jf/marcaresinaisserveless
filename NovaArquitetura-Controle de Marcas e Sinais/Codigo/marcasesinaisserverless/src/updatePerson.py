import json
import boto3
import os

def lambda_handler(event, context):

    if event['httpMethod'] != "PUT":
        return gerar_resposta(404, "Método Invalido")

    request = json.loads(event['body'])

    request_json = json.dumps(request)

    try:

        sqs = boto3.client('sqs')
        sqs_queue = os.environ['UPDATE_SQS_QUEUE']

        request_json = json.dumps(request)
        sqs.send_message(QueueUrl=sqs_queue, MessageBody=request_json)

        return gerar_resposta(200, request_json)

    except Exception as e:
        print(e)
        return gerar_resposta(500, "Erro ao processar: {e}")

def gerar_resposta(cod_resposta, mensagem):
    return {
        "statusCode": cod_resposta,
        "body": mensagem,
        "headers": { 
            'Content-Type': 'application/json',
            'Access-Control-Allow-Origin': '*',
            'Access-Control-Allow-Headers': '*',
            "Access-Control-Allow-Methods": "PUT" 
        }
    }