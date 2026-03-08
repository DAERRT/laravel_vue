<script setup lang="ts">
import { User } from '@/types';
import { Link, router, useForm } from '@inertiajs/vue3';

const props = defineProps<{
    user: User;
}>();

const formatDate = (dateString: string) => {
    if (!dateString) return '';
    const [year, month, day, time] = [dateString.slice(0, 4), dateString.slice(5, 7), dateString.slice(8, 10), dateString.slice(11, 19)];
    return `${day}.${month}.${year} ${time}`;
};

const datetimeCreated = formatDate(props.user?.created_at);
const datetimeUpdated = formatDate(props.user?.updated_at);

function logout() {
    if (confirm('Вы уверенны что хотите выйти?')) {
        return router.get('/logout');
    }
}

const deleteForm = useForm();

const submitDelete = () => {
    if (confirm('Вы уверенны что хотите удалить аккаунт?')) {
        if (confirm('Это действие нельзя будет отменить!')) {
            deleteForm.post('/profile/delete');
        }
    }
};
</script>

<template>
    <div class="button-wrapper">
        <Link href="/home">
            <button><- Назад</button>
        </Link>
    </div>
    <div class="mainwrapper">
        <div class="subwrapper">
            <label for="email">Имя</label>
            <input type="text" disabled="true" :value="props.user.name" />
            <label for="email">Email</label>
            <input type="text" disabled="true" :value="props.user.email" />
            <label for="email">Дата создания</label>
            <input type="text" disabled="true" :value="datetimeCreated" />
            <div class="datetime" v-if="datetimeCreated !== datetimeUpdated">
                <label for="email">Updated at</label>
                <input type="text" disabled="true" :value="datetimeUpdated" />
            </div>
            <div class="about-wrapper">
                <label for="">About Me</label>
                <textarea v-if="props.user.description" disabled="true">{{ props.user.description }}</textarea>
                <textarea v-else disabled="true" placeholder="Расскажите о себе"></textarea>
            </div>
            <Link href="/profile/edit">
                <button class="edit">Редактировать</button>
            </Link>
            <Link href="/profile/change-password">
                <button class="chpass">Смена пароля</button>
            </Link>
            <button class="logout" @click="logout">Выйти</button>
            <form @submit.prevent="submitDelete">
                <button class="delete">Удалить аккаунт</button>
            </form>
        </div>
    </div>
</template>

<style scoped>
.about-wrapper {
    display: flex;
    flex-direction: column;
}
.subwrapper button {
    padding: 5px;
    margin-top: 5px;
    margin-bottom: 5px;
    border-radius: 5px;
    width: 100%;
}
.edit {
    background: darkseagreen;
    transition: ease 0.2s;
}
.chpass {
    background: rgb(216, 195, 7);
    transition: ease 0.2s;
}
.logout {
    background: rgb(182, 82, 82);
    transition: ease 0.2s;
}
.delete {
    background: rgb(182, 82, 82);
    transition: ease 0.2s;
}
.edit:hover {
    background: rgb(115, 150, 115);
}
.chpass:hover {
    background: rgb(163, 147, 5);
}
.logout:hover {
    background: rgb(146, 66, 66);
}
.delete:hover {
    background: rgb(146, 66, 66);
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
.datetime {
    display: flex;
    flex-direction: column;
}
.mainwrapper {
    width: 100vw;
    height: 100vh;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    background-color: aliceblue;
}
.subwrapper {
    display: flex;
    flex-direction: column;
    background: rgb(143, 232, 248);
    padding: 20px;
    border-radius: 20px;
    box-shadow: 4px 4px 8px 0px rgba(34, 60, 80, 0.2);
}
.subwrapper input {
    background-color: aliceblue;
    border-radius: 20px;
    padding-left: 10px;
    margin-bottom: 5px;
    min-width: 500px;
}
.subwrapper label {
    padding-left: 10px;
}
textarea {
    min-height: 100px;
    background: aliceblue;
    padding: 5px;
    border-radius: 10px;
    margin-bottom: 5px;
}
</style>
