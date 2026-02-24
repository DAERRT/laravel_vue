<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();

const currentUser = computed(() => page.props.auth.user);
</script>

<template>
    <div class="wrapper">
        <div class="card">
            <h1>Home page</h1>
            <div v-if="currentUser">
                <div>Hello, {{ currentUser.name }}, welcome to the home page!</div>
                <div v-if="currentUser.roles.length == 1">
                    Your role is
                    <label class="role">{{ currentUser.roles[0].name }}</label>
                </div>
                <div v-else>
                    Your roles are <label v-for="role in currentUser.roles" class="role" :key="role.id">{{ role.name }}</label>
                </div>
            </div>
            <p v-else>Welcome to the home page!</p>
            <Link href="/admin" v-if="currentUser && currentUser.roles.some((role) => role.name === 'Admin')">
                <button v-if="currentUser && currentUser.roles.some((role) => role.name === 'Admin')">Панель администратора</button>
            </Link>
            <Link href="/logout">
                <button style="background: red">Выйти</button>
            </Link>
        </div>
    </div>
</template>

<style scoped>
.wrapper {
    display: flex;
    justify-content: center;
    align-items: center;
    width: 100%;
    height: 100vh;
    margin: 0 auto;
}
.card {
    text-align: center;
    background-color: darkgray;
    padding: 20px;
    border-radius: 10px;
}
.role {
    background-color: lightgray;
    padding: 3px;
    font-weight: bold;
    border-radius: 5px;
}

button {
    background-color: #007bff;
    color: white;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    margin:10px;
}
button:hover {
    transition: background-color 0.3s ease;
    background-color: #0069d9;
}
button:active {
    background-color: #0056b3;
}
</style>
