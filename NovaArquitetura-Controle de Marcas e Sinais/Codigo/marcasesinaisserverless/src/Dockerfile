FROM public.ecr.aws/lambda/python:3.9
COPY createPerson.py ${LAMBDA_TASK_ROOT}
COPY updatePerson.py ${LAMBDA_TASK_ROOT}
COPY deletePerson.py ${LAMBDA_TASK_ROOT}
COPY createProcess.py ${LAMBDA_TASK_ROOT}
COPY updateProcess.py ${LAMBDA_TASK_ROOT}
COPY deleteProcess.py ${LAMBDA_TASK_ROOT}
COPY getPerson.py ${LAMBDA_TASK_ROOT}
COPY requirements.txt ${LAMBDA_TASK_ROOT}
COPY db/ ${LAMBDA_TASK_ROOT}/db/
RUN python3.9 -m pip install -r requirements.txt -t .