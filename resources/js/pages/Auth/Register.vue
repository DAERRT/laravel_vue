<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';

interface Form {
    name: string;
    email: string;
    password: string;
    password_confirmation: string;
    remember_me: boolean;
}

const form = useForm<Form>({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    remember_me: false,
});

const submit = () => {
    form.post('/register', {
        onSuccess: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <div class="wrapper">
        <form action="" @submit.prevent="submit">
            <div class="h1"><h1>Регистрация</h1></div>
            <div class="inputs">
                <label for="">Имя</label>
                <input type="text" placeholder="Vasia" v-model="form.name" />

                <label for="">Email</label>
                <input type="email" placeholder="example@gmail.com" v-model="form.email" />

                <label for="">Пароль</label>
                <input type="password" placeholder="qwerty123" v-model="form.password" />

                <label for="">Повторите пароль</label>
                <input type="password" placeholder="qwerty123" v-model="form.password_confirmation" />
            </div>
            <div class="remember-me">
                <label for="">Запомнить меня?</label>
                <input type="checkbox" v-model="form.remember_me" />
            </div>
            <div class="button-wrapper">
                <button type="submit">Войти</button>
            </div>
            <div v-if="form.errors">
                <div v-for="(error, i) in form.errors" :key="i">
                    {{ error }}
                </div>
            </div>
            <div class="link-wrapper"><Link href="/login"> Есть аккаунт? Войти </Link></div>
        </form>
    </div>
</template>

<style scoped>
form * {
    margin: 5px;
}
.link-wrapper {
    display: flex;
    justify-content: center;
    font-size: 14px;
    color: blue;
}

form {
    display: flex;
    flex-direction: column;
    background: antiquewhite;
    width: 300px;
    padding: 10px;
    border-radius: 20px;
}
input {
    background: white;
    margin-top: 0;
    margin-bottom: 10px;
    border-radius: 20px;
    padding-left: 7px;
}
label {
    margin-left: 10px;
    margin-bottom: 0;
}

.remember-me {
    margin-top: 10px;
}

.wrapper {
    display: flex;
    justify-content: center;
    flex-direction: column;
    width: 100%;
    height: 100vh;
    align-content: center;
    align-items: center;
}

button {
    background: cornsilk;
    border-radius: 20px;
    width: fit-content;
    padding: 5px 30px;
}
button:hover {
    background: #b8b0a1;
    transition: ease 400ms;
}

.h1 {
    display: flex;
    justify-content: center;
}
h1 {
    font-size: 25px;
}

.inputs {
    display: flex;
    flex-direction: column;
    background: cornsilk;
    border-radius: 20px;
    padding: 10px;
}

.button-wrapper {
    display: flex;
    justify-content: center;
}
</style>
