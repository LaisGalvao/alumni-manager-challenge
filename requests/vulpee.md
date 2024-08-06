Deliveries
$ex = ExtraField::where('group_id','a333883c-76b8-4d8e-8049-63aa0dbafbff')->get();

Senders
$ex = ExtraField::where('group_id','fc0349f4-95c6-40e4-8d43-1a72d2a0ba49')->get();

{
    "movimentacoes": {
        "type": [0, "corrida"],
        "nome_cliente": [0, "test"],
        "tipo_entrega": [0, "caixa"],
        "dimensao": [0, "20 20 20 20"],
        "origin": [0, "Civic"],
        "destin": [0, "2022"],
        "data": [0, "FFV-2022"],
        "km": [0, "f"],
        "valor": [0, "000"],
        "rate": [0, "5"],
        "category": [0, "fasfgasf"],
        "id": [0, "00023362"]
    }
}

{
    "movimentacoes": {
        "type": [0, "saque"],
        "nome_cliente": [0, "-"],
        "tipo_entrega": [0, "-"],
        "dimensao": [0, "-"],
        "origin": [0, "pix"],
        "destin": [0, "16 99115-1456"],
        "data": [0, "FFV-2022"],
        "valor": [0, "000"],
        "km": [0, "-"],
        "rate": [0, "-"],
        "category": [0, "pendente"],
        "id": [0, "00023362"]
    }
}

{
    "user": {
        "name": "test",
        "movimentacoes": {
            "type": ["saque", "corrida"],
            "nome_cliente": ["-", "test"],
            "tipo_entrega": ["-", "caixa"],
            "dimensao": ["-", "20 20 20 20"],
            "origin": ["pix", "rua 1"],
            "destin": ["16 99115-1456", "rua 2"],
            "data": ["2022", "2222"],
            "valor": ["-000", "+111"],
            "id": ["00023362", "00455212"],
            "km": ["-", "3km"],
            "rate": ["-", "5"],
            "category": ["pendente", "particular"]
        }
    }
}

documento veiculo - rota postUpload

### rota de cadastro campo extra de um grupo
POST https://api.gold.shinier.com.br/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NjJhNGZiNC0yZjNhLTRiYjctOGIxMy0wZTVkY2VhZmI3ZTYiLCJqdGkiOiJlZjg3MTZlMTVmMjc4NTRkNzI1MTk5ZjdhY2I1NWM4NzQyYjY0YzJlZmIzOGFlOTNiZTViZDFkYjgwZWViY2IxNjEzNGYwODIwOGY2MzA4NyIsImlhdCI6MTY2NjY0NzQyNS4xMTUwNDIsIm5iZiI6MTY2NjY0NzQyNS4xMTUwNDYsImV4cCI6MTY5ODE4MzQyNS4xMDUwMDgsInN1YiI6ImZjYzE4MDJlLTliNDQtNDNjNS1iNzM1LWY4MmE3YmRmYTE3NCIsInNjb3BlcyI6W119.pIRWbp3Nlmnv-tGnGlRJkTGRXbVcZlg0--B33bpH-TlApoolWSq_VaHM9gYCnlXascLeVOY3az1TbuJDCTRc8Lj4HFY3WzuKgwjrbB2ZIPdKNyAJ9R583S_cucD--fPiVTHFY8dCq01s83Kk8IA7Z9XbG7TVjzo1gr1ersRmNCMTHfP8hsvlYHrJc2vGTReW3sJNEJx-mzWb37koKEIl2q_mUJuVxwOYy3lBmtjiy5z0VbTRd_G6TVIlrnhGtsfqiiY7m9ZyOW593CbBESr33lf-7PU6h85zTs6WpvPm0rjD9n4KBJKDeWjd-fZaLmk58KCAymH0CGI8gD880vvJHW6q1EgPALlAXLUhrPtY83J8OiDsN_Cgdm4a8QyXC3QMHvmE0hjbCxRu8_lN5Q_jccjhwGHpuIROXG32M1F33PDa0TsTuaFfvsik8C_xNeZQtdLukCXevj9cYWumEryzaD2Kuld1j6ClCd9bLlF3N8WTZeZTaQwF-Xe8hJIdcI2oIQQdosY591Sgz3ASfp9_AGonI05HQlswhOnZVS9iJVnPtTbbDBUDylIPkEb01CpmhHbjv-oJuoBoga-xAzcJd-l4bErh3qyyiKbs2ByOl9eJc0RVzNc5Fm2bxr7zwyl_8bQo6vdFKaiiezJKHBUPyxWakqI_H0xrrn_SQtf_Rf0

{
    "description": "Vehicles",
    "key": "vehicles",
    "type_value": "master",
    "type": "user",
    "group_id": "fc0349f4-95c6-40e4-8d43-1a72d2a0ba49"
}

### rota de cadastro campo extra de um grupo
POST http://127.0.0.1:8000/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.eyJhdWQiOiI5NjJhNGZiNC0yZjNhLTRiYjctOGIxMy0wZTVkY2VhZmI3ZTYiLCJqdGkiOiJlZjg3MTZlMTVmMjc4NTRkNzI1MTk5ZjdhY2I1NWM4NzQyYjY0YzJlZmIzOGFlOTNiZTViZDFkYjgwZWViY2IxNjEzNGYwODIwOGY2MzA4NyIsImlhdCI6MTY2NjY0NzQyNS4xMTUwNDIsIm5iZiI6MTY2NjY0NzQyNS4xMTUwNDYsImV4cCI6MTY5ODE4MzQyNS4xMDUwMDgsInN1YiI6ImZjYzE4MDJlLTliNDQtNDNjNS1iNzM1LWY4MmE3YmRmYTE3NCIsInNjb3BlcyI6W119.pIRWbp3Nlmnv-tGnGlRJkTGRXbVcZlg0--B33bpH-TlApoolWSq_VaHM9gYCnlXascLeVOY3az1TbuJDCTRc8Lj4HFY3WzuKgwjrbB2ZIPdKNyAJ9R583S_cucD--fPiVTHFY8dCq01s83Kk8IA7Z9XbG7TVjzo1gr1ersRmNCMTHfP8hsvlYHrJc2vGTReW3sJNEJx-mzWb37koKEIl2q_mUJuVxwOYy3lBmtjiy5z0VbTRd_G6TVIlrnhGtsfqiiY7m9ZyOW593CbBESr33lf-7PU6h85zTs6WpvPm0rjD9n4KBJKDeWjd-fZaLmk58KCAymH0CGI8gD880vvJHW6q1EgPALlAXLUhrPtY83J8OiDsN_Cgdm4a8QyXC3QMHvmE0hjbCxRu8_lN5Q_jccjhwGHpuIROXG32M1F33PDa0TsTuaFfvsik8C_xNeZQtdLukCXevj9cYWumEryzaD2Kuld1j6ClCd9bLlF3N8WTZeZTaQwF-Xe8hJIdcI2oIQQdosY591Sgz3ASfp9_AGonI05HQlswhOnZVS9iJVnPtTbbDBUDylIPkEb01CpmhHbjv-oJuoBoga-xAzcJd-l4bErh3qyyiKbs2ByOl9eJc0RVzNc5Fm2bxr7zwyl_8bQo6vdFKaiiezJKHBUPyxWakqI_H0xrrn_SQtf_Rf0

{
    "description": "Surname",
    "key": "surname",
    "type_value": "string",
    "type": "user",
    "master_extra_field": "5dc6daa0-8b69-46bc-bc87-abd9d4f740c1"
}

### rota de cadastro campo extra de um grupo
POST http://127.0.0.1:8000/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Model",
    "key": "model",
    "type_value": "string",
    "type": "user",
    "master_extra_field": "5dc6daa0-8b69-46bc-bc87-abd9d4f740c1"
}

### rota de cadastro campo extra de um grupo
POST http://127.0.0.1:8000/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Year",
    "key": "year",
    "type_value": "string",
    "type": "user",
    "master_extra_field": "5dc6daa0-8b69-46bc-bc87-abd9d4f740c1"
}

### rota de cadastro campo extra de um grupo
POST http://127.0.0.1:8000/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Board",
    "key": "board",
    "type_value": "string",
    "type": "user",
    "master_extra_field": "5dc6daa0-8b69-46bc-bc87-abd9d4f740c1"
}

### rota de cadastro campo extra de um grupo
POST http://127.0.0.1:8000/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Vehicle Document",
    "key": "vehicle_document",
    "type_value": "string",
    "type": "user",
    "master_extra_field": "5dc6daa0-8b69-46bc-bc87-abd9d4f740c1"
}

### rota de cadastro campo extra de um grupo
POST http://127.0.0.1:8000/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Receive Pix",
    "key": "receive_pix",
    "type_value": "bool",
    "type": "user",
    "group_id": "fc0349f4-95c6-40e4-8d43-1a72d2a0ba49"
}

### rota de cadastro campo extra de um grupo
POST http://127.0.0.1:8000/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Pix Key",
    "key": "pix_key",
    "type_value": "string",
    "type": "user",
    "group_id": "fc0349f4-95c6-40e4-8d43-1a72d2a0ba49"
}

### rota de cadastro campo extra de um grupo
POST http://127.0.0.1:8000/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Pix Key Value",
    "key": "pix_key_value",
    "type_value": "string",
    "type": "user",
    "group_id": "fc0349f4-95c6-40e4-8d43-1a72d2a0ba49"
}

### rota de cadastro campo extra de um grupo
POST http://127.0.0.1:8000/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Balance",
    "key": "balance",
    "type_value": "float",
    "type": "user",
    "group_id": "fc0349f4-95c6-40e4-8d43-1a72d2a0ba49"
}

### rota de cadastro campo extra de um grupo
POST http://127.0.0.1:8000/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Movimentacao",
    "key": "movimentacao",
    "type_value": "master",
    "type": "user",
    "group_id": "fc0349f4-95c6-40e4-8d43-1a72d2a0ba49"
}

// TODO: CRIAR OS CAMPOS EXTRAS FILHOS DA MOVIMENTACAO,

### rota de cadastro campo extra de um grupo
POST https://api.gold.shinier.com.br/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Type",
    "key": "type",
    "type_value": "string",
    "type": "user",
    "master_extra_field": "347b1874-6016-411e-a720-7c06b414e5e9"
}

### rota de cadastro campo extra de um grupo
POST https://api.gold.shinier.com.br/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Customer Name",
    "key": "customer_name",
    "type_value": "string",
    "type": "user",
    "master_extra_field": "347b1874-6016-411e-a720-7c06b414e5e9"
}

### rota de cadastro campo extra de um grupo
POST https://api.gold.shinier.com.br/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Delivery Type",
    "key": "delivery_type",
    "type_value": "string",
    "type": "user",
    "master_extra_field": "347b1874-6016-411e-a720-7c06b414e5e9"
}

### rota de cadastro campo extra de um grupo
POST https://api.gold.shinier.com.br/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Dimension",
    "key": "dimension",
    "type_value": "string",
    "type": "user",
    "master_extra_field": "347b1874-6016-411e-a720-7c06b414e5e9"
}

### rota de cadastro campo extra de um grupo
POST https://api.gold.shinier.com.br/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Origin",
    "key": "origin",
    "type_value": "string",
    "type": "user",
    "master_extra_field": "347b1874-6016-411e-a720-7c06b414e5e9"
}

### rota de cadastro campo extra de um grupo
POST https://api.gold.shinier.com.br/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Recipient",
    "key": "recipient",
    "type_value": "string",
    "type": "user",
    "master_extra_field": "347b1874-6016-411e-a720-7c06b414e5e9"
}

### rota de cadastro campo extra de um grupo
POST https://api.gold.shinier.com.br/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Date",
    "key": "date",
    "type_value": "string",
    "type": "user",
    "master_extra_field": "347b1874-6016-411e-a720-7c06b414e5e9"
}

### rota de cadastro campo extra de um grupo
POST https://api.gold.shinier.com.br/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "KM",
    "key": "km",
    "type_value": "string",
    "type": "user",
    "master_extra_field": "347b1874-6016-411e-a720-7c06b414e5e9"
}

### rota de cadastro campo extra de um grupo
POST https://api.gold.shinier.com.br/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Value",
    "key": "value",
    "type_value": "string",
    "type": "user",
    "master_extra_field": "347b1874-6016-411e-a720-7c06b414e5e9"
}

### rota de cadastro campo extra de um grupo
POST https://api.gold.shinier.com.br/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Rate",
    "key": "rate",
    "type_value": "string",
    "type": "user",
    "master_extra_field": "347b1874-6016-411e-a720-7c06b414e5e9"
}

### rota de cadastro campo extra de um grupo
POST https://api.gold.shinier.com.br/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Category",
    "key": "category",
    "type_value": "string",
    "type": "user",
    "master_extra_field": "347b1874-6016-411e-a720-7c06b414e5e9"
}

### rota de cadastro campo extra de um grupo
POST https://api.gold.shinier.com.br/api/extra_field/create HTTP/1.1
content-type: application/json
Authorization: Bearer eyJ0eXAiOiJKV1QiLCJhbGciOiJSUzI1NiJ9.

{
    "description": "Identification",
    "key": "identification",
    "type_value": "string",
    "type": "user",
    "master_extra_field": "347b1874-6016-411e-a720-7c06b414e5e9"
}
