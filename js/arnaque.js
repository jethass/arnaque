var ModuleArnaque = {
    config: [
        {
            route: 'ws/get_report_list_by_identical_ip.php',
            mapping: ['references', 'ip', 'mail_text_count', 'mail_customers', 'mail_content'],
            targetId: 'report-identical-ip'
        },
        {
            route: 'ws/get_report_list_by_identical_mail_type.php',
            mapping: ['reference', 'immat', 'phone', 'mail_count', 'mail_customers', 'mail_content'],
            targetId: 'report-identical-mail-type'
        },
        {
            route: 'ws/get_report_list_by_invalid_content.php',
            mapping: ['references', 'ips', 'mail_count', 'mail_customers', 'mail_content'],
            targetId: 'report-invalid-content'
        },
        {
            route: 'ws/get_report_list_by_invalid_ip.php',
            mapping: ['references', 'ip'],
            targetId: 'report-invalid-ip'
        }
    ],
    load: function () {
        var self = this
        this.config.forEach(function (config) {
            self.loadReporting(config.route, config.mapping, config.targetId);

            $('#link-' + config.targetId).click(function (event) {
                event.preventDefault();
                self.showReporting(config.targetId)
            })
        })

     },
    loadReporting: function (route, mapping, targetId) {
        var self = this
        $.get(route, function (data) {
            var targetTable = $('#' + targetId + ' > tbody');
            var htmlDatagrid = self.getHtmlGridContent(data, mapping,targetId);
            targetTable.empty();
            targetTable.append(htmlDatagrid);

        })

    },
    getHtmlGridContent: function (data, fieldsMapping,targetId) {
        var htmlDatagrid = '';

        data.forEach(function (element, index) {
            htmlDatagrid += '<tr>';
            fieldsMapping.forEach(function (field) {
                htmlDatagrid += '<td>' + element[field] + '</td>';
            })
            if (element['display_allow_ip_button'] !== undefined && element['display_allow_ip_button'] === true) {
                htmlDatagrid += '<td><button  type="button" data-ip="' + element["ip"] + '" class="btn btn-sm btn-success link-allow " data-toggle="modal" data-target="#modal">Autoriser l\'ip</button></td>';
            } else {
                htmlDatagrid += '<td></td>';
            }
            htmlDatagrid += '</tr>';
        })
        return htmlDatagrid;
    },
    showReporting: function (targetId) {
        this.config.forEach(function (config) {
            $('#link-' + config.targetId).parent().removeClass('active');
            if (config.targetId !== targetId) {
                $('#section-' + config.targetId).hide();
            }
        })
        this.config.forEach(function (config) {
            if (config.targetId === targetId) {
                $('#link-' + config.targetId).parent().addClass('active');
                $('#section-' + targetId).fadeIn();
            }
        })
    },
    initModalListenerAllowIp: function () {
        $('#modal').on('show.bs.modal', function (event) {
            var button = $(event.relatedTarget)
            var ip = button.data('ip')
            var modal = $(this)
            $.ajax({
                method: 'POST',
                url: 'ws/alow_ip.php',
                data: { allowedIp: ip }
            }).done(function(response) {
                modal.find('.modal-title').text('Notification')
                if (response.success == true) {
                    modal.find('.modal-body').text('L\'IP : ' + ip +' a été autorisée.');
                    button.hide();
                } else {
                    modal.find('.modal-body').text('L\'IP : ' + ip +' n\'a pas été autorisé a cause d\'un problème serveur.');
                }
            });
        })
    }
}

