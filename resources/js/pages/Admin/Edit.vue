<script setup lang="ts">
import { Link, useForm } from '@inertiajs/vue3';
import type { User } from '@/types';

interface Role {
    id: number;
    name: string;
    slug: string;
}

const props = defineProps<{ user: User; roles: Role[]; userRoles: Role[] }>();

const editUserForm = useForm<{
    id: number;
    name: string;
    email: string;
}>({
    id: props.user.id,
    name: props.user.name,
    email: props.user.email,
});

const formDropPass = useForm({});

const editUser = () => {
    editUserForm.post(`/edit/save`);
};

const dropPass = (id: number) => {
    if (confirm('Вы уверены, что хотите сбросить пароль?')) {
        formDropPass.get(`/drop/${id}`);
    }
};

const rolesForm = useForm<{ roles: number[] }>({
    roles: props.userRoles.map((r) => r.id),
});

const saveRoles = () => {
    rolesForm.post(`/edit/${props.user.id}/roles`, {
        preserveScroll: true,
    });
};

const deleteUser = (id: number) => {
    if (confirm('Вы уверены, что хотите удалить пользователя?')) {
        formDropPass.post(`/delete/${id}`);
    }
};
</script>

<template>
    <div class="wrapper">
        <div class="sub-wrapper">
            <h1>Изменение пользователя</h1>
            <form @submit.prevent="editUser" class="edit-user">
                <div class="inputs">
                    <input type="hidden" v-model="editUserForm.id" />
                    <label for="">Имя</label>
                    <input type="text" placeholder="Vasia" v-model="editUserForm.name" />

                    <label for="">Email</label>
                    <input type="email" placeholder="example@gmail.com" v-model="editUserForm.email" />
                </div>
                <button type="submit" :disabled="editUserForm.processing">Сохранить</button>
            </form>
            <div class="buttons">
                <form @submit.prevent="dropPass(user.id)" class="drop-pass">
                    <button type="submit">Сбросить пароль</button>
                </form>
                <form @submit.prevent="deleteUser(user.id)" class="delete-user">
                    <button type="submit">Удалить пользователя</button>
                </form>
            </div>

            <form class="roles" @submit.prevent="saveRoles">
                <h3>Роли</h3>

                <div class="roles-list">
                    <label v-for="role in roles" :key="role.id" class="role-item">
                        <input type="checkbox" :value="role.id" v-model="rolesForm.roles" />
                        <span>{{ role.name }}</span>
                    </label>
                </div>
                <button type="submit" :disabled="rolesForm.processing">Сохранить роли</button>
                <div v-if="rolesForm.errors.roles" class="error">
                    {{ rolesForm.errors.roles }}
                </div>
            </form>
            <Link href="/admin">
                <button type="button">&lt;- Назад</button>
            </Link>
        </div>
    </div>
</template>

<style scoped>
.roles {
    margin-top: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-width: 330px;
    width: 100%;
    padding: 20px;
    border-radius: 5px;
    background-color: #c1bfbf;
}
.roles-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
    max-width: 330px;
    padding: 20px;
    border-radius: 5px;
    background-color: #f5f5f5;
}
.role-item {
    display: flex;
    gap: 8px;
    align-items: center;
    max-width: 330px;
    padding: 10px;
    border-radius: 5px;
    background-color: #fff;
}
.roles button {
    padding: 10px 20px;
    background-color: #93df7d;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}
.roles button:hover {
    background-color: #78ba62;
    transition: all 0.4s ease-in-out;
}

.buttons {
    display: flex;
    gap: 10px;
}
.delete-user button {
    background-color: #ff5757;
    color: #fff;
    border: none;
    padding: 5px 10px;
    border-radius: 5px;
    cursor: pointer;
}
.delete-user button:hover {
    background-color: #c13e3e;
    transition: all 0.4s ease-in-out;
}

.sub-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: #f5f5f5;
    padding: 20px;
    border-radius: 5px;
    max-width: 330px;
}
.edit-user {
    align-items: center;
    justify-content: center;
    background-color: #f5f5f5;
    padding: 20px;
    border-radius: 5px;
    max-width: 330px;
}
.edit-user {
    display: flex;
    flex-direction: column;
    background-color: #c1bfbf;
    padding: 20px;
    border-radius: 5px;
    max-width: 330px;
}
.edit-user button {
    background-color: #93df7d;
    color: #fff;
    border: none;
    padding: 10px 20px;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 10px;
}
.edit-user button:hover {
    background-color: #78ba62;
    transition: all 0.4s ease-in-out;
}
.edit-user input {
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    font-size: 16px;
}
.edit-user input:focus {
    outline: none;
    border-color: #78ba62;
    background-color: #e6ffed;
    transition: all 0.4s ease-in-out;
}

.drop-pass button {
    padding: 5px 10px;
    background-color: #93df7d;
    color: #fff;
    border: none;
    border-radius: 5px;
    cursor: pointer;
}

.drop-pass button:hover {
    background-color: #78ba62;
    transition: all 0.4s ease-in-out;
}

.buttons {
    display: flex;
    gap: 10px;
}

.wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 20px;
    width: 100%;
    height: 100vh;
    margin: 0 auto;
}
.sub-wrapper {
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    gap: 20px;
}
.h1 {
    text-align: center;
}
.inputs {
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.roles {
    margin-top: 20px;
    display: flex;
    flex-direction: column;
    gap: 10px;
}
.roles-list {
    display: flex;
    flex-direction: column;
    gap: 6px;
}
.role-item {
    display: flex;
    gap: 8px;
    align-items: center;
}
.error {
    color: red;
}
</style>
