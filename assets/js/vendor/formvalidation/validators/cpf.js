export default function cpf() {
	return {
		validate(input) {
			if( input.value === '' )
			{
				return {valid: true};
			}

			const value = input.value.replace(/[^0-9]/g, '');

			if( value.length !== 11 )
			{
				return {valid: false};
			}

			var soma = 0;
			var resto;

			if( value == '00000000000' ) return {valid: false};
			for( i = 1; i <= 9; i++ ) soma = soma + parseInt(value.substring(i - 1, i)) * (11 - i);
			resto = (soma * 10) % 11;

			if( (resto == 10) || (resto == 11) ) resto = 0;
			if( resto != parseInt(value.substring(9, 10)) ) return {valid: false};

			soma = 0;
			for( i = 1; i <= 10; i++ ) soma = soma + parseInt(value.substring(i - 1, i)) * (12 - i);
			resto = (soma * 10) % 11;

			if( (resto == 10) || (resto == 11) ) resto = 0;
			if( resto != parseInt(value.substring(10, 11)) ) return {valid: false};

			return {valid: true};
		},
	};
}