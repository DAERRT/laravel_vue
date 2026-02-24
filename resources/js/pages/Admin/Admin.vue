<script setup lang="ts">
import { Link, useForm, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';
import type { User } from '@/types';

defineProps<{
    users: User[];
}>();

const form = useForm({});

const deleteUser = (id: number) => {
    if (confirm('Вы уверены, что хотите удалить этого пользователя?')) {
        form.post(`/delete/${id}`, {
            preserveScroll: true,
            onSuccess: () => {
                // Опционально: показать уведомление об успехе
                console.log('Пользователь успешно удален');
                alert('Пользователь удален!');
            },
            onError: (errors) => {
                console.error('Ошибка при удалении:', errors);
            },
        });
    }
};

const editUser = (id: number) => {
    form.get(`/edit/${id}`);
};

const page = usePage();

const currentUser = computed(() => page.props.auth.user);
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
            <table v-if="users.length">
                <tbody>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Roles</th>
                        <th>Actions</th>
                    </tr>
                    <tr v-for="user in users" :key="user.id">
                        <td>{{ user.id }}<label v-if="currentUser.id == user.id"> (Вы)</label></td>
                        <td>{{ user.name }}</td>
                        <td>{{ user.email }}</td>
                        <td>
                            <div v-if="user.roles.length" class="role-wrapper">
                                <label class="role" v-for="role in user.roles" :key="role.id">{{ role.name }} </label>
                            </div>
                        </td>
                        <td>
                            <div class="actions">
                                <form class="delete" @submit.prevent="deleteUser(user.id)">
                                    <button class="delete-btn" :disabled="currentUser?.id === user.id || form.processing" type="submit">
                                        Delete
                                    </button>
                                </form>

                                <form class="edit" @submit.prevent="editUser(user.id)">
                                    <button class="edit-btn" :disabled="currentUser?.id === user.id || form.processing" type="submit">Edit</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                </tbody>
            </table>
            <div v-else>
                <label style="color: red">Пока нет пользователей</label>
            </div>
        </div>
    </div>
</template>

<style scoped>
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

.delete-btn:disabled {
    margin: 5px;
    background: #8a2121;
    padding: 5px;
    border-radius: 10px;
}

.edit-btn:disabled {
    margin: 5px;
    background: #0000a1;
    padding: 5px;
    border-radius: 10px;
}

.edit-btn {
    background-color: blue;
    margin: 5px;
    padding: 5px;
    border-radius: 10px;
}

.role {
    background-color: lightgray;
    padding: 3px;
    font-weight: bold;
    border-radius: 5px;
    margin-right: 5px;
}
.role-wrapper {
    border: none;
}

table,
td,
th {
    border: solid black 2px;
    padding: 5px;
    margin-left: auto;
    margin-right: auto;
    margin-top: 20px;
}

table {
    min-width: 600px;
}

.delete-btn:hover:enabled {
    background: #a12929;
    font-size: 19px;
    margin: 0;
    transition: ease 400ms;
}

.edit-btn:hover:enabled {
    background: #2929a1;
    font-size: 19px;
    margin: 0;
    transition: ease 400ms;
}

.role:hover {
    background-color: #d3d3d3;
    transition: all 0.4s ease-in-out;
}
</style>
