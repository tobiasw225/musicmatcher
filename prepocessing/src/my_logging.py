import logging
import logging.config
import sys
def print_progress(iteration, total, prefix='', suffix='',
                   decimals=2, bar_length=100):
    """
    (not my own work)
    Call in a loop to create terminal progress bar
    @params:
        iteration   - Required  : current iteration (Int)
        total       - Required  : total iterations (Int)
        prefix      - Optional  : prefix string (Str)
        suffix      - Optional  : suffix string (Str)
        decimals    - Optional  : positive number of decimals in percent complete (Int)
        bar_length   - Optional  : character length of bar (Int)
    """
    format_str = "{0:." + str(decimals) + "f}"
    percents = format_str.format(100 * (iteration / float(total)))
    filled_length = int(round(bar_length * iteration / float(total)))
    bar = '+' * filled_length + '-' * (bar_length - filled_length)
    sys.stdout.write('\r%s |%s| %s%s %s' % (prefix, bar, percents, '%', suffix)),
    if iteration == total:
        sys.stdout.write('\n')
    sys.stdout.flush()


def get_my_logger(fout_name="", log_level=logging.INFO):
    """

    :param fout_name:
    :param log_level:
    :return:
    """

    log_format = '%(message)s'

    logger = logging.getLogger(__name__)
    logger.setLevel(log_level)

    handler = logging.handlers.RotatingFileHandler(fout_name)
    handler.setLevel(logging.DEBUG)

    formatter = logging.Formatter(log_format)
    handler.setFormatter(formatter)
    logger.addHandler(handler)

    logging.basicConfig(level=log_level,
                        format=log_format)

    return logger