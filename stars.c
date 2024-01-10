#include<stdio.h>
#include<stdlib.h>

/*
Input: ./a.out 5

Output:

*
**
***
****
*****

*/
int main(int argc, char *argv[]){

	int count = atoi(argv[1]);
	for(int i=0; i<=count; i++)
	{
		for(int j=0; j<i; j++){
			printf("*");
		}
		printf("\n");
	}
	printf("\n");
	return 0;
}
