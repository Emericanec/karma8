# Karma8 test task
## Шаги по установке:

- Копируем .env:

    `cp .env.example .env`

- Меняем переменные для подключения нашей бд
- Запускаем инициализацию БД схемы:

    `php ./karma8 initdb`
- Устанавливем наш crontab файл:

    `crontab /path/to/project/crontab`

## Все досупные команды:

1) Добавляем емейлы в очередь на проверку:
```
php ./karma8 check_email_enqueue
```

2) Добавляем емейлы в очередь на отправку уведомлений:
```
php ./karma8 email_notification_enqueue <days:int>
```

3) Обработка очереди проверки емейлов:
```
php ./karma8 check_email_worker
```

4) Обработка очереди отправки уведомлений:
```
php ./karma8 email_notification_worker <max_workers_count:int> <days:int>
```

5) Запуск первоначальной схемы БД
```
php ./karma8 initdb
```