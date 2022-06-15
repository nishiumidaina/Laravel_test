num = 36
divisors = []
for i in range(1, num+1):
    if num % i == 0:
        divisors.append(i)
print(divisors)