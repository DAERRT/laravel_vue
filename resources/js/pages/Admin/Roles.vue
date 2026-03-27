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
    <div class="md-sidenav-layout">
        <aside class="md-sidenav">
            <h1 class="md-title" style="font-size: 22px">Админ панель</h1>
            <Link href="/home"><button class="md-btn md-btn-tonal" style="width: 100%">Домашняя</button></Link>
            <Link href="/admin"><button class="md-btn md-btn-tonal" style="width: 100%">Пользователи</button></Link>
            <Link href="/roles"><button class="md-btn" style="width: 100%">Роли</button></Link>
            <button class="md-btn md-btn-tonal" style="width: 100%" disabled>Скоро...</button>
            <p class="md-sidenav-footer">ТИУ 2026</p>
        </aside>

        <main class="md-page">
            <div class="md-container">
                <div class="md-card md-stack">
                    <h2 class="md-title" style="font-size: 24px">Роли</h2>

                    <div v-if="props.roles.length >= 1" class="md-table-wrap">
                        <table class="md-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Slug</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><button class="md-btn md-btn-success">Добавить</button></td>
                                </tr>
                                <tr v-for="role in props.roles" :key="role.id">
                                    <td>{{ role.id }}</td>
                                    <td>{{ role.name }}</td>
                                    <td>{{ role.slug }}</td>
                                    <td>
                                        <div class="md-row">
                                            <form @submit.prevent="">
                                                <button class="md-btn md-btn-danger" :disabled="form.processing" type="submit">Delete</button>
                                            </form>

                                            <form @submit.prevent="">
                                                <button class="md-btn" :disabled="form.processing" type="submit">Edit</button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <div v-else class="md-note">Ролей пока нет</div>
                </div>
            </div>
        </main>
    </div>
</template>
