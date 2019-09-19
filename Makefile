start:
	php -S localhost:8000 public/index.php
create-table:
	php ./src/Connect/TableCreator.php