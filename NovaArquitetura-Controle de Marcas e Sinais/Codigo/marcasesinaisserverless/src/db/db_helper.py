import boto3
from boto3.dynamodb.conditions import Key
import os
import time

class DBHelper:
    def __init__(self) -> None:
        environment = os.environ['ENVIRONMENT']
        persons_table_name = os.environ['PERSONS_TABLE_NAME']
        
        if environment == "AWS_SAM_LOCAL":
            dynamodb_dev_uri = os.environ['DYNAMODB_DEV_URI']
            self.dynamodb = boto3.resource('dynamodb', endpoint_url=dynamodb_dev_uri)
        else:
            self.dynamodb = boto3.resource('dynamodb')
        
        self.persons_table = self.dynamodb.Table(persons_table_name)


    def update_person(self, request, status):
        return self.persons_table.put_item(
            Item={
                'cpf': request['cpf'],
                'nome': request['nome'],
                'telefone': request['telefone'],
                'data_cadastro': int(time.time()),
                'status': status,
            }
        )

    def delete_person(self, request):
        return self.persons_table.delete_item(Key={'cpf': request['cpf']})
    
    def get_person_status(self, cpf):
        response = self.get_records_by_key(self.persons_table, 'cpf', cpf)
        if 'Items' in response:
            return response['Items']
        return None
    
    def get_records_by_key(self, table, key, value):
        try:
            response = table.query(
                KeyConditionExpression=Key(key).eq(value)
            )
            return response
        except Exception as error:
            print(error)
            raise error