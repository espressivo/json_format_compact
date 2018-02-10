import sys

limit = int(sys.argv[1])
inStr = inEsc = False
lBrace = lambda x: chr(ord(x)-2)

tmp = ['']
stack = [[]]
for line in sys.stdin:
  for c in line:
    if inStr:
      tmp[-1] += c
      if inEsc: inEsc = False
      elif c == '"': inStr = False
      elif c == '\\': inEsc = True
    else:
      if not c.strip(): continue
      if c == ',':
        stack[-1].append(tmp[-1])
        tmp[-1] = ''
      elif c in ['[', '{']:
        tmp.append('')
        stack.append([])
      elif c in [']', '}']:
        if tmp[-1]: stack[-1].append(tmp[-1])
        tmp.pop()
        arr = stack.pop()
        inline = ', '.join(arr)
        pad = int(c == '}')
        if len(tmp[-1]) + len(inline) + 2 + pad*2 <= limit:
          if inline: tmp[-1] += (' '*pad).join([lBrace(c), inline, c])
          else: tmp[-1] += lBrace(c) + c
        else:
          tmp[-1] = tmp[-1] + lBrace(c) + '\n' + ',\n'.join('  '*len(stack)+x for x in arr) + "\n" + '  '*(len(stack)-1) + c
      else:
        if c == '"': inStr = True
        tmp[-1] += c + ' '*(c == ':')

if tmp[-1]: stack[-1].append(tmp[-1])
print('\n'.join(stack[-1]))
