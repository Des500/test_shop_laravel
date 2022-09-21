## Тестовый магазин на Laravel
## https://testshoplaravel.w101.ru/
### Технологии:
Laravel v8.83.23 <br>
Bootstrap 5.1.3 <br>
Javascript <br>
Jquery 3.6.0 <br>
SASS/CSS3 <br>

### Административный доступ:
Логин<br>
admin@w101.ru<br>
Пароль<br>
111222<br>
Административный/пользовательский доступ определяется содержанием поля role в таблице users (admin/user)<br>

### Созданные/измененные файлы проекта
#### js
public/js/shop.js 
#### css
resourse/sass/app.scss
#### шаблоны
resourse/views
#### router
routes/web.php
#### mail
app/Mail/
#### models
app/Models/
#### controllers
app/Http/Controllers
#### migrations
database/migrations
#### сборка
webpack.mix.js

## Описание
Все товары разбиты по определенным категориям (каждому товару соответствует 1 категория).<br>
Добавление товара в корзину возможно из каталога и со странички товара с указанием количества.<br>
Возможно редактирование содержания и полная очистка корзины.
### Пользователь
- магазина может добавить товар в корзину, сформировать заказ, оплатить заказ.<br>
- Отслеживание заказов - в личном кабинете пользователя.<br>
- Возможно оплатить ранее сформированный заказ, добавить в корзину ранее сформированный заказ.<br> 
- При оплате, отгрузке товара - приходит оповещение на е-майл<br>

### Администратор
- магазина может проверять все заказы, менять статус заказа<br>
- Добавлять/отредактировать товар<br>
- Изменить статус товара (опубликован, в наличии)<br>
- Добавлять/отредактировать категории<br>
- Отслеживание заказов - личном кабинете.<br>
<br>

