<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed } from 'vue';

const page = usePage();
const currentUser = computed(() => page.props.auth.user);
</script>

<template>
    <div class="md-center-page">
        <div class="md-card md-stack" style="max-width: 680px; width: 100%">
            <h1 class="md-title">Home page</h1>
            <div class="md-stack" v-if="currentUser">
                <div>Hello, {{ currentUser.name }}, welcome to the home page!</div>
                <div v-if="currentUser.roles.length == 1" class="md-row">
                    <span>Your role is</span>
                    <label class="md-chip">{{ currentUser.roles[0].name }}</label>
                </div>
                <div v-else class="md-row">
                    <span>Your roles are</span>
                    <label v-for="role in currentUser.roles" class="md-chip" :key="role.id">{{ role.name }}</label>
                </div>
            </div>
            <p v-else class="md-note">Welcome to the home page!</p>
            <div class="md-row">
                <Link href="/admin" v-if="currentUser && currentUser.roles.some((role) => role.name === 'admin')">
                    <button class="md-btn md-btn-tonal">Панель администратора</button>
                </Link>
                <Link href="/profile">
                    <button class="md-btn md-btn-success">Профиль</button>
                </Link>
                <Link href="/articles">
                    <button class="md-btn">Статьи</button>
                </Link>
                <Link href="/logout">
                    <button class="md-btn md-btn-danger">Выйти</button>
                </Link>
            </div>
        </div>
    </div>
</template>
