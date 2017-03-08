/**
 * showdown generate html
 * @author Weilong Wang <github.com/wilon>
 */
$(function(){
    String.prototype.trim = function() {
        return this.replace(/(^\s*)|(\s*$)/g, '');
    };

    showdown.setOption('tables', true)
            .setOption('tablesHeaderId', true)

    var converter = new showdown.Converter();

    var mdinput = $('#mdinput').text().trim(),
        x = mdinput.indexOf('##'),
        y = mdinput.lastIndexOf('------'),
        headerInput = mdinput.substr(0, x).trim(),
        footerInput = mdinput.substr(y + 6).trim();
        bodyInput = mdinput.substr(x, y - x).trim();

    if ($('#header').html() && $('#footer').html()) {
        // header & footer
        $('#header').html(converter.makeHtml(headerInput));
        $(document).attr('title', $('#header').find('h1').text());
        $('#footer').html(converter.makeHtml(footerInput));
        // body
        var dom = '<div>' + converter.makeHtml(bodyInput) + '</div>',
            bodyHtml = '',
            tmpBar = [];
        $(dom).children().map(function(index) {
            var tagName = $(this).prop('tagName');
            if (/H\d+/.test(tagName) == true) {
                var id = MD5($(this).text()).substr(0, 6) + index;
                if (tagName == 'H2' && tmpBar.length != 0) {
                    generateBar(tmpBar);
                    tmpBar = [];
                }
                tmpBar.push({
                    id: id,
                    text: $(this).text()
                });
                $(this).attr('id', id);
            }
            bodyHtml += $(this).prop("outerHTML");
            if (index == $(dom).children().length - 1) {
                generateBar(tmpBar);
            }
            return;
        });
        $('#body').html(bodyHtml);
    } else {
        $('#body').html(converter.makeHtml(mdinput));
        $(document).attr('title', $('#body').find('h1').text());
        $('#body').find('table').addClass('table table-bordered table-striped');
    }

    function generateBar(liArr) {
        if (liArr.length == 0) return;
        var h2 = $('<a/>', {
                href: '#' + liArr[0].id,
                text: liArr[0].text
            });
        var li = '';
        liArr.map(function(elem, index) {
            if (index == 0) return;
            li += `<li><a href="#${elem.id}">${elem.text}</a></li>`;
            return;
        });
        var barli = `<li><a href="#${liArr[0].id}">${liArr[0].text}</a><ul class="nav" style="display: block;">${li}</ul></li>`;
        $('#navbar').append(barli);
    }
})