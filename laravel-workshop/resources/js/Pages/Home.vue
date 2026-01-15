<script setup>
import Logo from '../Components/Logo.vue';
import { Link } from '@inertiajs/vue3';
</script>

<template>
    <div class="bg-pixl-dark text-pixl-light relative flex h-dvh w-full flex-col md:block md:overflow-clip">
        <!-- Background image -->
        <div class="fixed inset-0 overflow-clip">
            <img src="/images/Official-Login-BG.png" alt=""
                class="absolute inset-y-0 left-[15%] h-full w-full mask-l-from-80% object-cover opacity-30" />
        </div>

        <main
            class="isolate mx-auto grid max-w-[1000px] flex-grow place-items-center px-8 max-md:pt-16 md:h-full xl:max-w-6xl">
            <div class="flex w-full flex-col items-center justify-between gap-8 md:flex-row md:gap-16">
                <!-- Logo + Word Stack -->
                <div>
                    <div class="flex items-baseline gap-3">
                        <Logo class="w-36" />
                        <div aria-hidden="true" class="text-pixl relative hidden text-4xl uppercase md:block">
                            <!-- Top -->
                            <div class="absolute bottom-full my-2 flex flex-col gap-2 opacity-20">
                                <div class="flex flex-col gap-2 opacity-50">
                                    <p>Coder</p>
                                    <p>Art</p>
                                    <p>Writer</p>
                                    <p>Media</p>
                                    <p>Designer</p>
                                    <p>Coder</p>
                                    <p>Designer</p>
                                    <p>Art</p>
                                    <p>Writer</p>
                                    <p>Coder</p>
                                    <p>Art</p>
                                    <p>Coder</p>
                                    <p>Art</p>
                                    <p>Writer</p>
                                </div>
                                <p>Media</p>
                            </div>
                            <!-- Anchor -->
                            <p>Everyone</p>
                            <!-- Bottom -->
                            <div class="absolute my-2 flex flex-col gap-2 opacity-20">
                                <p>Coder</p>
                                <p>Art</p>
                                <div class="flex flex-col gap-2 opacity-50">
                                    <p>Coder</p>
                                    <p>Art</p>
                                    <p>Writer</p>
                                    <p>Media</p>
                                    <p>Designer</p>
                                    <p>Coder</p>
                                    <p>Designer</p>
                                    <p>Art</p>
                                    <p>Writer</p>
                                    <p>Coder</p>
                                    <p>Art</p>
                                    <p>Coder</p>
                                    <p>Art</p>
                                    <p>Writer</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="max-w-full pb-16 min-[360px]:w-72 sm:w-80">
                    <h1 class="text-pixl text-center text-2xl sm:text-3xl md:text-left">
                        A place for the cool squares.
                    </h1>
                    <div class="mt-8 flex flex-col gap-3 text-center sm:mt-12 md:mt-16 md:w-68">
                        <a class="bg-pixl-dark/50 hover:bg-pixl-dark/60 active:bg-pixl-dark/75 border-pixl/50 hover:border-pixl/60 active:border-pixl/75 text-pixl border px-4 py-1.5"
                            href="/feed">Sign in with Google</a>
                        <a class="bg-pixl-dark/50 hover:bg-pixl-dark/60 active:bg-pixl-dark/75 border-pixl/50 hover:border-pixl/60 active:border-pixl/75 text-pixl border px-4 py-1.5"
                            href="/feed">Sign in with Apple</a>
                        <p>or</p>

                        <a class="bg-pixl hover:bg-pixl/90 active:bg-pixl/95 text-pixl-dark border border-transparent px-4 py-1.5"
                            href="/feed">Create an Account</a>
                        <p class="mt-12 text-left text-sm sm:mt-16 md:mt-20">
                            Already have an account?
                        </p>
                        <Link class="bg-pixl hover:bg-pixl/90 active:bg-pixl/95 text-pixl-dark border border-transparent px-4 py-1.5"
                            :href="route('login')">Sign in</Link>
                    </div>
                </div>
            </div>
        </main>

        <footer class="relative pb-3 md:fixed md:inset-x-0 md:bottom-0">
            <div class="text-pixl flex flex-col items-center gap-1.5 p-4 text-center">
                <p>All Rights Reserved. Pixl Media For Everyone*</p>
                <p class="text-xs opacity-50">
                    *except for badgers, they’re $&@*holes.
                </p>
            </div>
            <!-- White noise -->
            <div class="absolute inset-x-0 bottom-0 h-4 bg-[url(/images/white-noise.gif)]"></div>
            <!-- Pictogram -->
            <svg class="absolute right-4 bottom-8 w-7 grayscale max-sm:hidden" viewBox="0 0 29 43"
                xmlns="http://www.w3.org/2000/svg" fill="none">
                <g fill="#ECA749" opacity=".5" style="mix-blend-mode: luminosity">
                    <path
                        d="M7.058 0H0v7.058h7.058V0Zm0 7.058H0v7.059h7.058V7.058ZM28.234 0h-7.058v7.058h7.058V0Zm0 7.059h-7.058v7.058h7.058V7.059ZM7.058 28.233H0v7.059h7.058v-7.059Z">
                    </path>
                    <path d="M7.058 35.291H0v7.059h7.058v-7.06Zm21.176-7.058h-7.058v7.059h7.058v-7.059Z"></path>
                    <path
                        d="M28.234 35.291h-7.058v7.059h7.058v-7.06ZM14.117 21.175H7.059v7.058h7.058v-7.058Zm7.058-7.058h-7.058v7.058h7.058v-7.058Zm-7.058 0H7.059v7.058h7.058v-7.059Zm7.058 7.058h-7.058v7.058h7.058v-7.058Z">
                    </path>
                </g>
            </svg>
        </footer>
    </div>
</template>