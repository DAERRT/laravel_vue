<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';

interface Role {
    id: number;
    name: string;
    slug: string;
}

const props = defineProps<{
    roles: Role[];
}>();

const form = useForm();
</script>

<template>
    <div class="main-wrapper">
        <div class="sidebar">
            <div class="sidebar-top">
                <div class="sidebar-header-wrapper">
                    <h1 class="sidebar-header">Админ панель</h1>
                </div>
                <div class="sidebar-buttons">
                    <Link href="/home">
                        <button>Домашняя</button>
                    </Link>
                    <Link href="/admin">
                        <button>Пользователи</button>
                    </Link>
                    <Link href="/roles">
                        <button>Роли</button>
                    </Link>
                    <button>Скоро...</button>
                </div>
            </div>
            <div class="sidebar-bottom">
                <p>ТИУ 2026</p>
            </div>
        </div>
        <div class="wrapper">
            <table v-if="props.roles.length >= 1">
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Slug</th>
                    <th>Actions</th>
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td>
                        <button class="add-btn">Добавить</button>
                    </td>
                </tr>
                <tr v-for="role in props.roles" :key="role.id">
                    <td>{{ role.id }}</td>
                    <td>{{ role.name }}</td>
                    <td>{{ role.slug }}</td>
                    <td>
                        <div class="actions">
                            <form class="delete" @submit.prevent="">
                                <button class="delete-btn" :disabled="form.processing" type="submit">Delete</button>
                            </form>

                            <form class="edit" @submit.prevent="">
                                <button class="edit-btn" :disabled="form.processing" type="submit">Edit</button>
                            </form>
                        </div>
                    </td>
                </tr>
            </table>
            <div v-else>Ролей пока нет</div>
        </div>
    </div>
</template>

<style scoped>
.actions {
    display: flex;
    justify-content: center;
    align-items: center;
}

table,
th,
td {
    border: solid black 2px;
    padding: 5px;
    margin-left: auto;
    margin-right: auto;
    margin-top: 20px;
}
.main-wrapper {
    width: 100%;
    height: 100vh;
    display: flex;
    flex-direction: row;
}

.sidebar {
    height: 100vh;
    background: #929fae;
    width: 300px;
    border: 2px solid;
    display: flex;
    flex-direction: column;
    justify-content: space-between;
}

.sidebar-header {
    padding: 10px;
}
.sidebar-header-wrapper {
    display: flex;
    justify-content: center;
    border-bottom: 2px solid;
}
.sidebar-top {
    border: none;
}
.sidebar-buttons {
    display: flex;
    flex-direction: column;
    border: none;
}

.sidebar-buttons button {
    border: 2px solid;
    background: #d1c7c7;
    margin: 1px 0;
    height: 50px;
    width: 100%;
}

.sidebar-buttons button:hover {
    background: #9c9494;
    transition: ease 0.2s;
}

.sidebar-bottom {
    border-top: 2px solid;
    height: 80px;
    display: flex;
    justify-content: center;
    align-content: center;
    align-items: center;
}
.sidebar-bottom p {
    height: fit-content;
    font-size: 13px;
}

.wrapper {
    width: 100%;
    height: 100vh;
}

.actions {
    display: flex;
    justify-content: center;
    align-items: center;
}

.delete-btn {
    margin: 5px;
    background: #ea3939;
    padding: 5px;
    border-radius: 10px;
}

.edit-btn {
    background-color: blue;
    margin: 5px;
    padding: 5px;
    border-radius: 10px;
}
.add-btn {
    background-color: #45ed7c;
    margin: 0;
    padding: 5px;
    border-radius: 10px;
    width: 100%;
}
.add-btn:hover {
    background-color: #35b55c;
    transition: ease 400ms;
}

table {
    min-width: 600px;
}

.delete-btn:hover {
    background: #a12929;
    font-size: 19px;
    margin: 0;
    transition: ease 400ms;
}

.edit-btn:hover {
    background: #2929a1;
    font-size: 19px;
    margin: 0;
    transition: ease 400ms;
}
</style>
