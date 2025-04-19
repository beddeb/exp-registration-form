<?php

class RegistrationException extends Exception
{
    private $field;

    public function __construct($message = "", $code = 0, $field = null)
    {
        parent::__construct($message, $code);
        $this->field = $field;
    }

    public function getField()
    {
        return $this->field;
    }
}

class regForm
{
    public static function validateName($name)
    {
        if (empty($name)) {
            throw new RegistrationException("Имя не может быть пустым.", 100, 'name');
        }
        if (!preg_match('/^[a-zA-Zа-яА-ЯёЁ]+$/u', $name)) {
            throw new RegistrationException("Имя должно содержать только буквы.", 101, 'name');
        }
        return true;
    }

    public static function validateAge($age)
    {
        if (!is_numeric($age)) {
            throw new RegistrationException("Возраст должен быть числом.", 102, 'age');
        }
        if ($age <= 0) {
            throw new RegistrationException("Возраст должен быть положительным числом.", 103, 'age');
        }
        if ($age > 120) {
            throw new RegistrationException("Возраст должен быть меньше 120 лет.", 104, 'age');
        }
        return true;
    }

    public static function validateEmail($email)
    {
        if (empty($email)) {
            throw new RegistrationException("Email не может быть пустым.", 105, 'email');
        }
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new RegistrationException("Некорректный формат email.", 106, 'email');
        }
        return true;
    }

    public static function register($name, $age, $email)
    {
        try {
            self::validateName($name);
            self::validateAge($age);
            self::validateEmail($email);

            return "Регистрация успешна!\nИмя: $name\nВозраст: $age\nEmail: $email";
        } catch (RegistrationException $e) {
            return "Ошибка: " . $e->getMessage();
        }
    }
}

// Получения данных из формы (для отладки - из консоли)
$name = trim(readline());
$age = trim(readline());
$email = trim(readline());

echo UserRegistration::register($name, $age, $email) . "\n";
?>