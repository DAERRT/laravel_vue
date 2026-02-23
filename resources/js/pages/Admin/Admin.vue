<script setup lang="ts">
import { useForm, usePage } from '@inertiajs/vue3';
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
                    <div v-if="user.roles.length">
                        <span class="role" v-for="role in user.roles" :key="role.id">{{ role.name }} </span>
                    </div>
                </td>
                <td class="actions">
                    <form class="delete" @submit.prevent="deleteUser(user.id)">
                        <button class="delete-btn" :disabled="currentUser?.id === user.id || form.processing" type="submit">Delete</button>
                    </form>

                    <form class="edit" @submit.prevent="editUser(user.id)">
                        <button class="edit-btn" :disabled="currentUser?.id === user.id || form.processing" type="submit">Edit</button>
                    </form>
                </td>
            </tr>
        </tbody>
    </table>
    <div v-else>
        <label style="color: red">Пока нет пользователей</label>
    </div>
</template>

<style scoped>
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

.role {
    background-color: lightgray;
    padding: 3px;
    font-weight: bold;
    border-radius: 5px;
    margin-right: 5px;
}

table,
td,
th {
    border: solid black 2px;
    padding: 5px;
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

.role:hover {
    background-color: #d3d3d3;
    transition: all 0.4s ease-in-out;
}
</style>
