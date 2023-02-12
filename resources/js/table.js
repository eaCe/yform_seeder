window.yTable = () => {
    return {
        tableName: 'rex_',
        tableLabel: '',
        perPage: 50,
        active: false,
        fields: [],
        success: false,
        error: '',
        loader: document.getElementById('rex-js-ajax-loader'),
        init() {
            this.resetData();
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
        fakeData() {
            this.tableName = 'rex_test' + Math.floor(Math.random() * 100) + 1;
            this.tableLabel = 'Label';
            this.perPage = 33;
            this.active = true;
            this.fields = [
                {
                    field_name: 'text',
                    type: 'value',
                    uid: this.getUID(),
                    name: 'text_name',
                    label: 'text_label',
                }
            ];
        },
        addValue(name) {
            this.addField(name, 'value');
            this.resetValue();
        },
        resetValue() {
            this.$refs.value.value = '';
        },
        addValidation(name) {
            this.addField(name, 'validation');
            this.resetValidation();
        },
        resetValidation() {
            this.$refs.validation.value = '';
        },
        addField(name, type) {
            this.fields.push({
                field_name: name,
                type: type,
                db_type: '',
                uid: this.getUID(),
                name: '',
                label: ''
            })
        },
        deleteField(index) {
            if (confirm('Delete field?')) {
                this.fields.splice(index, 1);
            }
        },
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
