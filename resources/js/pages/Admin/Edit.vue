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
    <div class="md-page">
        <div class="md-container md-stack" style="max-width: 760px">
            <div class="md-card md-stack">
                <h1 class="md-title">Изменение пользователя</h1>

                <form @submit.prevent="editUser" class="md-form">
                    <input type="hidden" v-model="editUserForm.id" />

                    <div class="md-field">
                        <label class="md-label">Имя</label>
                        <input class="md-input" type="text" placeholder="Vasia" v-model="editUserForm.name" />
                    </div>

                    <div class="md-field">
                        <label class="md-label">Email</label>
                        <input class="md-input" type="email" placeholder="example@gmail.com" v-model="editUserForm.email" />
                    </div>

                    <button class="md-btn" type="submit" :disabled="editUserForm.processing">Сохранить</button>
                </form>

                <div class="md-row">
                    <form @submit.prevent="dropPass(user.id)"><button class="md-btn md-btn-warning" type="submit">Сбросить пароль</button></form>
                    <form @submit.prevent="deleteUser(user.id)"><button class="md-btn md-btn-danger" type="submit">Удалить пользователя</button></form>
                </div>

                <form class="md-form" @submit.prevent="saveRoles">
                    <h3 class="md-title" style="font-size: 20px">Роли</h3>

                    <label v-for="role in roles" :key="role.id" class="md-row" style="justify-content: flex-start">
                        <input type="checkbox" :value="role.id" v-model="rolesForm.roles" />
                        <span>{{ role.name }}</span>
                    </label>

                    <button class="md-btn md-btn-success" type="submit" :disabled="rolesForm.processing">Сохранить роли</button>
                    <div v-if="rolesForm.errors.roles" class="md-error">{{ rolesForm.errors.roles }}</div>
                </form>

                <div>
                    <Link href="/admin"><button class="md-btn md-btn-tonal" type="button">&lt;- Назад</button></Link>
                </div>
            </div>
        </div>
    </div>
</template>
