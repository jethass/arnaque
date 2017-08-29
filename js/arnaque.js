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
            targetTable.find('.link-allow').click(function(event){
                event.preventDefault();
                self.allowIp(event);
            });
            targetTable.find('.link-disallow').click(function(event){
                event.preventDefault();
                self.disallowIp(event);
            });
        })
    },
    getHtmlGridContent: function (data, fieldsMapping,targetId) {
        var htmlDatagrid = '';
        data.forEach(function (element, index) {
            htmlDatagrid += '<tr>';
            fieldsMapping.forEach(function (field) {
                htmlDatagrid += '<td>' + element[field] + '</td>';
            })

            htmlDatagrid += '<td>';

            if (element['display_allow_ip_button'] !== undefined && element['display_allow_ip_button'] === true) {
                htmlDatagrid += '<button  type="button" data-ip="' + element["ip"] + '" class="btn btn-sm btn-success link-allow " >Autoriser l\'ip</button>';
            } else if(element['display_allow_ip_button'] !== undefined && element['display_allow_ip_button'] === false) {
                htmlDatagrid += '<abbr style="color:#4cae4c;">IP autorisée</abbr>';
            }

            if (element['display_disallow_ip_button'] !== undefined && element['display_disallow_ip_button'] === true) {
                htmlDatagrid += '&nbsp;&nbsp;<button  type="button" data-ip="' + element["ip"] + '" class="btn btn-sm btn-danger link-disallow " >Bannir l\'ip</button>';
            } else if(element['display_disallow_ip_button'] !== undefined && element['display_disallow_ip_button'] === false) {
                htmlDatagrid += '&nbsp;&nbsp;<abbr style="color:#000;">IP bannie</abbr>';
            }

            htmlDatagrid += '</td>';
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
    allowIp: function (event) {
        var self = this;
        var button = $(event.currentTarget);
        var ip = button.data('ip');
        $.ajax({
                method: 'POST',
                url: 'ws/alow_ip.php',
                data: { allowedIp: ip }
            }).done(function(response) {
                if (response.success == true) {
                    button.parent().html('Traitement en cours...');
                    self.load();
                }
        });
    },
    disallowIp: function (event) {
        var self = this;
        var button = $(event.currentTarget);
        var ip = button.data('ip');
        $.ajax({
            method: 'POST',
            url: 'ws/disalow_ip.php',
            data: { disallowedIp: ip }
        }).done(function(response) {
            if (response.success == true) {
                button.parent().html('Traitement en cours...');
                self.load();
            }
        });
    }
}

