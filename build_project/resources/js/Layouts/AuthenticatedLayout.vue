<script setup lang="ts">
import {inject, ref} from 'vue';
import ApplicationLogo from '@/Components/ApplicationLogo.vue';
import Dropdown from '@/Components/Dropdown.vue';
import DropdownLink from '@/Components/DropdownLink.vue';
import NavLink from '@/Components/NavLink.vue';
import ResponsiveNavLink from '@/Components/ResponsiveNavLink.vue';
import { Link } from '@inertiajs/vue3';

const showingNavigationDropdown = ref(false);
const canLogin = inject('canLogin')
</script>

<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav
                class="border-b border-gray-100 bg-white"
            >
                <!-- Primary Navigation Menu -->
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex h-16 justify-between">
                        <div class="flex">
                            <!-- Logo -->
                            <div class="flex shrink-0 items-center">
                                <Link :href="route('dashboard')">
                                    <ApplicationLogo class="block h-9 w-auto fill-current text-gray-800"/>
                                </Link>
                            </div>
                        </div>
                        <div class="flex">
                            <!-- Navigation Links -->
                            <div v-if="!canLogin" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink
                                    :href="route('dashboard')"
                                    :active="route().current('dashboard')"
                                >
                                    Projects
                                </NavLink>
                                <NavLink
                                    :href="route('materials.index')"
                                    :active="route().current('materials.index')"
                                >
                                    Materials
                                </NavLink>
                                <NavLink
                                    :href="route('equipments.index')"
                                    :active="route().current('equipments.index')"
                                >
                                    Equipments
                                </NavLink>
                                <NavLink
                                    :href="route('construction_crews.index')"
                                    :active="route().current('construction_crews.index')"
                                >
                                    Construction crews
                                </NavLink>
                                <NavLink
                                    :href="route('profile.edit')"
                                    :active="route().current('profile.edit')"
                                >
                                    Profile
                                </NavLink>
                                <NavLink
                                    :href="route('logout')"
                                    method="post"
                                    as="button"
                                >
                                    Log Out
                                </NavLink>
                            </div>

                            <div v-if="canLogin" class="hidden space-x-8 sm:-my-px sm:ms-10 sm:flex">
                                <NavLink
                                    :href="route('login')"
                                >
                                    Log in
                                </NavLink>

                                <NavLink
                                    :href="route('register')"
                                >
                                    Register
                                </NavLink>
                            </div>
                        </div>



                        <!-- Hamburger -->
                        <div class="-me-2 flex items-center sm:hidden">
                            <button
                                @click="
                                    showingNavigationDropdown =
                                        !showingNavigationDropdown
                                "
                                class="inline-flex items-center justify-center rounded-md p-2 text-gray-400 transition duration-150 ease-in-out hover:bg-gray-100 hover:text-gray-500 focus:bg-gray-100 focus:text-gray-500 focus:outline-none"
                            >
                                <svg
                                    class="h-6 w-6"
                                    stroke="currentColor"
                                    fill="none"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        :class="{
                                            hidden: showingNavigationDropdown,
                                            'inline-flex':
                                                !showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                    <path
                                        :class="{
                                            hidden: !showingNavigationDropdown,
                                            'inline-flex':
                                                showingNavigationDropdown,
                                        }"
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M6 18L18 6M6 6l12 12"
                                    />
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Responsive Navigation Menu -->
                <div
                    :class="{
                        block: showingNavigationDropdown,
                        hidden: !showingNavigationDropdown,
                    }"
                    class="sm:hidden"
                >
                    <div v-if="canLogin" class="space-y-1 pb-3 pt-2">
                        <ResponsiveNavLink
                            :href="route('login')"
                        >
                            Log in
                        </ResponsiveNavLink>

                        <ResponsiveNavLink
                            :href="route('register')"
                        >
                            Register
                        </ResponsiveNavLink>
                    </div>

                    <!-- Responsive Settings Options -->
                    <div
                        v-if="!canLogin"
                        class="border-t border-gray-200 pb-1 pt-4"
                    >
                        <div class="px-4">
                            <div
                                class="text-base font-medium text-gray-800"
                            >
                                {{ $page.props.auth.user.first_name }}
                            </div>
                            <div class="text-sm font-medium text-gray-500">
                                {{ $page.props.auth.user.email }}
                            </div>
                        </div>

                        <div class="mt-3 space-y-1">
                            <ResponsiveNavLink
                                :href="route('dashboard')"
                                :active="route().current('dashboard')"
                            >
                                Projects
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('materials.index')"
                                :active="route().current('materials.index')"
                            >
                                Materials
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('equipments.index')"
                                :active="route().current('equipments.index')"
                            >
                                Equipments
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('construction_crews.index')"
                                :active="route().current('construction_crews.index')"
                            >
                                Construction crews
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('profile.edit')"
                                :active="route().current('profile.edit')"
                            >
                                Profile
                            </ResponsiveNavLink>
                            <ResponsiveNavLink
                                :href="route('logout')"
                                method="post"
                                as="button"
                            >
                                Log Out
                            </ResponsiveNavLink>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Page Heading -->
            <header
                class="bg-white shadow"
                v-if="$slots.header"
            >
                <div class="mx-auto max-w-7xl px-4 py-6 sm:px-6 lg:px-8 flex justify-between items-center">
                    <slot name="header" />
                </div>
            </header>

            <!-- Page Content -->
            <main class="pb-6">
                <slot />
            </main>
        </div>
    </div>
</template>
