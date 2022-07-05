def read_csv(file_name):
    """Reads a line from the spreadsheet."""
    for row in open(file_name, 'r'):
        yield row