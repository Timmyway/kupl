<?php use App\AppConfig;
$config = AppConfig::getInstance();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kit uploader</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-eOJMYsd53ii+scO/bJGFsiCZc+5NDVN2yr8+0RDqr0Ql0h+rP48ckxlpbzKgwra6" crossorigin="anonymous">
</head>
<body>
    <div class="container p-5" id="app">
        <div style="position: fixed; right: 0; top: 0; width: 320px; background: rgba(0, 2, 4, .8); height: auto; z-index: 99; color: white; font-size: .9rem; overflow-y: auto; padding: .5rem;">
            <button class="btn-sm btn-info" @click="showKits = !showKits">{{ showKits ? 'Hide' : 'Show' }} kits</button>
            <div v-show="showKits">
                <ul class="list-group">
                    <template v-for="kit in kits.kits" :key="kit.id">
                    <li class="list-group-item">
                        <a :href="`${siteURL}${kit.location}${kitName}`" target="_blank">
                            {{ kit.name }}
                        </a>
                    </li>
                    </template>
                </ul>
            </div>
        </div>
        <h1>Upload HTML Kit (Au format .zip svp)</h1>
        <br>
        <form action="<?= $config->get('api') ?>upload" method="POST" enctype="multipart/form-data">
            <div class="form-group mb-2">
                <input type="text" class="form-control" name="save_folder" placeholder="Campaign name" v-model="campaign" @keyup="quickReplace">
            </div>
            <div class="form-group mb-2">
                <input class="form-control" type="file" name="file" accept=".zip" />
            </div>
            <input class="btn btn-primary" type="submit" name="submit" value="submit"/>
        </form>

        <br>
        
        <div class="form-group mt-2">
            <input type="text" class="form-control mb-2" v-model="kitName" placeholder="Nom du KIT" @keyup="quickReplace">
            <div class="alert alert-success">
                <a :href="kitURL" target="_blank">{{ kitURL }}</a>
            </div>
        </div>

        <div class="row">
            <div class="col-6">
                <textarea  @input="quickReplace" class="form-control" name="" id="" cols="30" rows="10" v-model="code.input"></textarea>
            </div>
            <div class="col-6">
                <textarea class="form-control" name="" id="" cols="30" rows="10" v-model="code.output" readonly></textarea>
            </div>           
        </div>
    </div>

    <script src="https://unpkg.com/vue@3"></script>
    <script src="https://unpkg.com/axios/dist/axios.min.js"></script>

    <script>
        const { createApp, reactive, onMounted } = Vue

        createApp({
            setup() {
                const siteURL = 'http://localhost:8020/';
                let kits = reactive({ kits: {}});
                function fetchKits() {
                    axios.get(siteURL + 'api/kits')
                    .then((response) => {
                        console.log(response.data.kits);
                        kits.kits = response.data.kits;
                    })
                    .catch((err) => {
                        console.log(err);
                    })
                }

                fetchKits();

                return { kits, siteURL }
            },
            data() {
                return {
                    url: "<?= 'http://'.$_SERVER['HTTP_HOST'].'/kupl/kits/' ?>",
                    kitName: '',
                    campaign: '',
                    code: {
                        input: '',
                        output: ''
                    },
                    showKits: true
                }
            },
            computed: {
                kitURL() {
                    return `${this.url}${this.campaign}/${this.kitName}`;
                },
                test() {
                    let pattern = /src="(.*?)"/gi
                    const matches = this.code.input.matchAll(pattern);
                    const r = [];
                    for (const match of matches) {
                        r.push(match[1]);
                    }
                    return r;
                }
            },
            methods: {
                quickReplace() {
                    this.code.output = '';
                    setTimeout(() => {
                        let pattern = /<.*?img.*?src="(.*?)"/gi
                        this.code.output = this.code.input.replaceAll(pattern, `<img src="${this.kitURL}/$1"`)
                    }, 100)                    
                }
            }
        }).mount('#app')
        </script>
</body>
</html>