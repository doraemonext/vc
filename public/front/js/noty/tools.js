/**
 * 自定义JS工具函数
 */

function msg(text, type)
{
    if (type == 'danger') {
        type = 'error';
    }

    noty({
        text: text,
        type: type,
        layout: 'bottomCenter',
        timeout: 3000
    });
}

function msg_top(text, type)
{
    if (type == 'danger') {
        type = 'error';
    }

    noty({
        text: text,
        type: type,
        layout: 'top',
        timeout: 3000
    });
}