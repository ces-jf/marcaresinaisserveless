from db import db_helper
import json
from datetime import datetime

def lambda_handler(event=None, context=None):

    if event['httpMethod'] != "GET":
        return generate_response(404, "Método Invalido")

    query_params = event['queryStringParameters']

    if not validate_params(query_params):
        return generate_response(404, "Invalid request")
       
    try:
        dbHelper = db_helper.DBHelper()
        response = dbHelper.get_person_status(query_params['cpf'])
        print(response)
        if response is None or len(response) == 0:
            return generate_response(404, f"Request not found")

        return generate_response(200, {
            "cpf": response[0]['cpf'],
            "nome": response[0]['nome'],
            "telefone": response[0]['telefone'],
            "status": response[0]['status'],
        })

    except Exception as e:
        print(e)
        return generate_response(500, f"Erro ao processar: {e}")

def generate_response(response_code, message):
    return {
        "statusCode": response_code,
        "body": json.dumps(message),
        "headers": { 
            "Access-Control-Allow-Headers" : "Content-Type",
            "Access-Control-Allow-Origin": "*", 
            "Access-Control-Allow-Methods": "GET"
        }
    }

def validate_params(query_params):
    payload_valid = True
    keys_required = {'cpf'}
    for key in keys_required:
        if key not in query_params:
            payload_valid = False
            break

    return payload_valid        
