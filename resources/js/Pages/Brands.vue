<script setup lang="ts">
import { ref, onMounted } from 'vue';
import { Head } from '@inertiajs/vue3';
import Header from '@/Partials/Header.vue';

defineProps<{
    canLogin?: boolean;
    canRegister?: boolean;
    laravelVersion: string;
    phpVersion: string;
}>();

const brands = ref([]);
// const geolocation = ref(null);
//
// const cloudflareFallbackURLs = ['https://one.one.one.one/cdn-cgi/trace',
//     'https://1.0.0.1/cdn-cgi/trace',
//     'https://cloudflare-dns.com/cdn-cgi/trace',
//     'https://cloudflare-eth.com/cdn-cgi/trace',
//     'https://cloudflare-ipfs.com/cdn-cgi/trace',
//     'https://workers.dev/cdn-cgi/trace',
//     'https://pages.dev/cdn-cgi/trace',
//     'https://cloudflare.tv/cdn-cgi/trace',
// ];
//
// async function getCloudflareJSON() {
//     let data = await fetchWithFallback(cloudflareFallbackURLs).then(res=>res.text());
//     let arr = data.trim().split('\n').map(e=>e.split('='));
//     return Object.fromEntries(arr)['loc'];
// }
// async function fetchWithFallback(links, obj) {
//     let response;
//     for (let link of links) {
//         try {
//             response = await fetch(link, obj)
//             if (response.ok)
//                 return response;
//         } catch (e) { }
//     }
//     return response;
// }
//
//
// getCloudflareJSON().then(response => {
//     geolocation.value = response;
// });


const getBrands = () => {
    axios.post('api/brands')
        .then(response => brands.value = response.data)
        .catch(error => console.log(error));
};

onMounted(() => getBrands());

function handleImageError() {
    document.getElementById('background')?.classList.add('!hidden');
}
</script>

<template>
    <Head title="Welcome" />
    <div class="bg-gray-50 text-black/50 dark:bg-black dark:text-white/50">
        <img
            id="background"
            class="absolute -left-20 top-0 max-w-[877px]"
            src="https://laravel.com/assets/img/welcome/background.svg"
        />
        <div
            class="relative min-h-screen flex flex-col items-center justify-center selection:bg-[#FF2D20] selection:text-white"
        >
            <div class="relative w-full max-w-2xl px-6 lg:max-w-7xl">
                <Header :canLogin="canLogin" :canRegister="canRegister" />

                <main class="mt-12">
                    <div class="grid content-start md:content-around bg-white">
                        <table>
                            <caption>Brands</caption>
                            <thead>
                            <tr>
                                <th scope="col">ID</th>
                                <th scope="col">Brand</th>
                                <th scope="col">Image</th>
                                <th scope="col">Rating</th>
                                <th scope="col">GeoLocation</th>
                            </tr>
                            </thead>
                            <tbody>
                            <template v-for="(brand, index) in brands.data">
                            <tr>
                                <td :scope="{ 'row': index !== 0 }" data-label="ID">{{ brand.id }}</td>
                                <td data-label="Brand">
                                    {{ brand.name }}
                                </td>
                                <td data-label="Image">
                                    <template v-if="brand.image">
                                        <img :src="brand.image_url" :alt="brand.name" style="display: inline-block" />
                                    </template>
                                </td>
                                <td data-label="Rating">
                                    <div>
                                        <div class="stars">
                                            <div :style="{ width: brand.rating_percentage + '%' }"></div>
                                        </div>
                                    </div>
                                </td>
                                <td data-label="GeoLocation">{{ brand.geolocation }}</td>
                            </tr>
                            </template>
                            </tbody>
                        </table>
                    </div>
                </main>

                <footer class="py-16 text-center text-sm text-black dark:text-white/70">
                    Laravel v{{ laravelVersion }} (PHP v{{ phpVersion }})
                </footer>
            </div>
        </div>
    </div>
</template>
<style scoped lang="scss">
.stars,
.starsbg {
    width: 85px;
    height: 16px;
    background: url(/static/rating.png) 0 bottom repeat-x;
    margin: 15px auto;
    overflow: hidden;
    position: relative;
}

.stars div,
.starsbg div.starsfg {
    position: absolute;
    height: 100%;
    background: url(/static/rating.png) 0 0 repeat-x;
}

table {
    border: 1px solid #ccc;
    border-collapse: collapse;
    margin: 0;
    padding: 0;
    width: 100%;
    table-layout: fixed;
}

table caption {
    font-size: 1.5em;
    margin: .5em 0 .75em;
}

table tr {
    background-color: #f8f8f8;
    border: 1px solid #ddd;
    padding: .35em;
}

table th,
table td {
    padding: .625em;
    text-align: center;
}

table th {
    font-size: .85em;
    letter-spacing: .1em;
    text-transform: uppercase;
}

@media screen and (max-width: 600px) {
    table {
        border: 0;
    }

    table caption {
        font-size: 1.3em;
    }

    table thead {
        border: none;
        clip: rect(0 0 0 0);
        height: 1px;
        margin: -1px;
        overflow: hidden;
        padding: 0;
        position: absolute;
        width: 1px;
    }

    table tr {
        border-bottom: 3px solid #ddd;
        display: block;
        margin-bottom: .625em;
    }

    table td {
        border-bottom: 1px solid #ddd;
        display: block;
        font-size: .8em;
        text-align: right;
    }

    table td::before {
        /*
        * aria-label has no advantage, it won't be read inside a table
        content: attr(aria-label);
        */
        content: attr(data-label);
        float: left;
        font-weight: bold;
        text-transform: uppercase;
    }

    table td:last-child {
        border-bottom: 0;
    }
}
</style>
