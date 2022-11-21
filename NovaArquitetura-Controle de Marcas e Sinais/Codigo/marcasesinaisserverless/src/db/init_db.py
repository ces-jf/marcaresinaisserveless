import boto3

def create_persons_table(dynamodb):
    table = dynamodb.create_table(
        TableName='serverless-persons',
        KeySchema=[
            {
                'AttributeName': 'cpf',
                'KeyType': 'HASH'
            }
        ],
        AttributeDefinitions=[
            {
                'AttributeName': 'cpf',
                'AttributeType': 'S'
            }
        ],
        ProvisionedThroughput={
            'ReadCapacityUnits': 3,
            'WriteCapacityUnits': 3
        }
    )
    return table



if __name__ == '__main__':
    dynamodb = boto3.resource('dynamodb', endpoint_url="http://localhost:8000")
    table = create_persons_table(dynamodb)
    print("Table status:", table.table_status)