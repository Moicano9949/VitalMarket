
Tables_in_if0_37584007_db_vitalmarket
carrito
productos
usuarios

---carrito----
Field
Type
Null
Key
Default
Extra
id
int(11)
NO
PRI
NULL
auto_increment
user_id
int(11)
NO
MUL
NULL
producto_id
int(11)
NO
MUL
NULL
nombre
varchar(255)
YES
NULL
precio
decimal(10,2)
YES
NULL
imagen
varchar(255)
YES
NULL
cantidad
int(11)
YES
1

---productos----


Field
Type
Null
Key
Default
Extra
id
int(11)
NO
PRI
NULL
auto_increment
nombre
varchar(255)
NO
NULL
descripcion
text
YES
NULL
precio
decimal(10,2)
NO
NULL
stock
int(11)
YES
0
categoria
varchar(100)
YES
NULL
fecha_creacion
timestamp
NO
current_timestamp()
imagen
varchar(255)
YES
NULL

---usuarios---


Field
Type
Null
Key
Default
Extra
id
int(11)
NO
PRI
NULL
auto_increment
username
varchar(50)
NO
UNI
NULL
password
varchar(255)
NO
NULL
email
varchar(50)
NO
NULL
token
varchar(255)
YES
NULL


# VitalMarket
# VitalMarket
