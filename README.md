## Оглавление
* [Постановка задачи](#постановка-задачи)
* [Функционал](#функционал)
* [Компоненты](#компоненты)
* [Инструкция](#инструкция)
* [Выводы](#выводы)

### Постановка задачи
Написать RESTful ToDoList API без использования фрейморков

### Функционал
* Взаимодействие с логикой API с помощью http запросов
* Хранение в таблице параметров задачи, которую нужно выполнить
* Структура таблицы:

	| name         | id           | body         | status       |
	|--------------|--------------|--------------|--------------|
	| varchar(255) | varchar(255) | varchar(255) | varchar(255) |

* CRUD методы для контроля операций над содержимым таблицы
* Валидация входных параметров

### Компоненты
- **Технологии**
	- php 7.2
	- PostgreSQL 10.9
	- Composer
	- Git
- **Использованные библиотеки**
	- Ramsey/Uuid - генерация id в формате Uuid
	- Zend/Diactors - представление request и response в виде объектов
	- Aura/Routing - http mapping
- **Утилиты**
	- GNU Make 4.2.1

### Инструкция
1. Изменить конфигурацию файла db_configExample.ini
	- /path/to/project/src/Connect/db_config.Example.ini
	- Изменить название (db_configExample.ini -> db_config.ini)
	- Изменить его внутренние параметры в соответствии с используемой б\д
2. Создать таблицу для хранения задач при помощи ввода команды утилиты make
	```
	$ make create-table
	```
3. Запустить встроенный в php веб-сервер командой make
	```
	$ make start
	```
4. Перейти по одному из существующих роутов:

| Функция | URL | Метод | Параметры |
|:--------------------------:|:----------------------------:|:------:|:--------------------------------------------------:|
| Вернуть конкретную задачу | *HOST*:8000/tasks/{id} | GET | id - идентификатор задачи |
| Вернуть весь список задач | *HOST*:8000/tasks | GET | - |
| Добавить задачу | *HOST*:8000/tasks | POST | name - название задачи;  body - описание задачи |
| Изменить содержимое задачи | *HOST*:8000/tasks/{id}/body | PUT | id - идентификатор задачи;  body - описание задачи |
| Изменить статус задачи | *HOST*:8000/tasks{id}/status | PUT | id - идентификатор задачи;  status - статус задачи |
| Удалить задачу | *HOST*:8000/tasks/{id} | DELETE | id - идентификатор задачи |


### Выводы
В ходе написания моего первого проекта я узнал о следующих вещах:
- **Написание кода и его оформление**
	- Data Hiding
	- Type Hinting
- **Парадигмы и паттерны программирования и проектирования**
	- Named Constructors
	- Data Transfer Object
	- Dependency Injection
	- OOP
	- MVC
	- SOLID
	- GRASP
	- REST
	- LIFT
	- CRUD