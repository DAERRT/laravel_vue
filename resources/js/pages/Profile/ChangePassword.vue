<script setup lang="ts">
import { useForm } from '@inertiajs/vue3';
import { Link } from '@inertiajs/vue3';

const form = useForm<{
    password: string;
    newPassword: string;
    confirm_newPassword: string;
}>();

const submit = () => {};
</script>

<template>
    <div class="button-wrapper">
        <Link href="/profile">
            <button><- Назад</button>
        </Link>
    </div>
    <div class="wrapper">
        <form @submit.prevent="submit">
            <label for="">Старый пароль</label>
            <input type="password" v-model="form.password" />
            <label for="">Новый пароль</label>
            <input type="password" v-model="form.newPassword" />
            <label for="">Подтверлите новый пароль</label>
            <input type="password" v-model="form.confirm_newPassword" />
            <button class="save">Сохранить</button>
        </form>
    </div>
</template>

<style scoped>
.wrapper {
    width: 100vw;
    height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: aliceblue;
}
form {
    display: flex;
    flex-direction: column;
    background: rgb(143, 232, 248);
    padding: 20px;
    border-radius: 20px;
    box-shadow: 4px 4px 8px 0px rgba(34, 60, 80, 0.2);
}
.button-wrapper {
    padding-left: 20px;
    padding-top: 20px;
    position: fixed;
}
.button-wrapper button {
    background-color: rgb(143, 232, 248);
    padding: 10px;
    border-radius: 20px;
    transition: ease 0.2s;
}
.button-wrapper button:hover {
    background-color: rgb(128, 207, 221);
    padding: 15px;
    font-size: large;
    font-weight: bold;
}
form input {
    background-color: aliceblue;
    border-radius: 20px;
    padding-left: 10px;
    margin-bottom: 5px;
    min-width: 500px;
}
form label {
    padding-left: 10px;
}
textarea {
    min-height: 100px;
    background: aliceblue;
    padding: 5px;
    border-radius: 10px;
    margin-bottom: 5px;
}
.save {
    background: darkseagreen;
    transition: ease 0.2s;
    padding: 5px;
    margin-top: 5px;
    margin-bottom: 5px;
    border-radius: 5px;
    width: 100%;
}
.save:hover {
    background: rgb(115, 150, 115);
}
</style>
