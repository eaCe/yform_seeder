<script>
    window.ySeeder = () => {
        return {
            tableName: '',
            tableLabel: '',
            columns: [],
            success: false,
            error: '',
            loader: document.getElementById('rex-js-ajax-loader'),
            init() {
                // this.resetData();
                // this.fakeData();
            },
            resetData(preventResetSuccess) {
                // reset data
                this.tableName = 'rex_';
                this.tableLabel = '';
                this.perPage = 50;
                this.active = true;
                this.fields = [];
                this.error = '';

                if (!preventResetSuccess) {
                    this.success = false;
                }

                // :|
                setTimeout(() => {
                    this.resetValue();
                    this.resetValidation();
                })
            },
            async showFields(event) {
                /**
                 * @type {Response}
                 */
                const response = event.detail.clone();
                const jsonString = await response.text();
                const data = JSON.parse(jsonString);

                this.tableLabel = data.label;
                this.tableName = data.name;
                this.columns = data.columns;
            },
            getType(dbType) {
                switch (dbType) {
                    case 'text':
                    case 'varchar(192)':
                        break;
                    default:
                        return 'text';
                        break;
                }
            },
            // resetValue() {
            //     this.$refs.value.value = '';
            // },
            // addValidation(name) {
            //     this.addField(name, 'validation');
            //     this.resetValidation();
            // },
            // resetValidation() {
            //     this.$refs.validation.value = '';
            // },
            getUID() {
                let timestamp = new Date().getTime();
                return 'xxxxxxxxxxxxxxxxxxx'.replace(/[x]/g, function (c) {
                    const r = (timestamp + Math.random() * 16) % 16 | 0;
                    timestamp = Math.floor(timestamp / 16);
                    return (c === 'x' ? r : (r & 0x3 | 0x8)).toString(16);
                });
            },
            showLoader() {
                this.loader.classList.add('rex-visible');
            },
            hideLoader() {
                this.loader.classList.remove('rex-visible');
            },
            showSuccess() {
                this.success = true;
                this.resetData(true);

                setTimeout(() => {
                    this.success = false;
                }, 4000);
            },
            async showError(event) {
                /**
                 * @type {Response}
                 */
                const response = event.detail.clone();
                this.error = await response.text();
            },
        }
    };

</script>

<div x-data="ySeeder()">

<!--    <div class="alert alert-danger" x-text="error" x-show="error!==''"></div>-->
<!--    <div class="alert alert-success" x-show="success">Die Tabelle wurde angelegt.</div>-->

    <div class="row">
        <div class="col-md-4">
            <?php
            /**
             * value selection.
             */
            $fragment = new rex_fragment();
            echo $fragment->parse('yform_seeder/table-select.php');
            ?>
        </div>
    </div>

    <hr>

    <?php
    /**
     * value selection.
     */
    $fragment = new rex_fragment();
    echo $fragment->parse('yform_seeder/table-fields.php');
    ?>

    <hr>

    <?php
    /**
     * buttons.
     */
//    $fragment = new rex_fragment();
//    echo $fragment->parse('yform_seeder/create-button.php');
    ?>
</div>
