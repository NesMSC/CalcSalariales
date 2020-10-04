

<template v-if="menu==0">
	<Escritorio></Escritorio>
</template>
<template v-if="menu==1">
	<Padministrativo></Padministrativo>	
</template>
<template v-if="menu==2">
	<Pdocente></Pdocente>	
</template>
<template v-if="menu==3">
	<Pobrero></Pobrero>	
</template>
<template v-if="menu==4">
	<h1>Tabuladores</h1>
</template>
<template v-if="menu==5">
	<Beneficios></Beneficios>	
</template>
<template v-if="menu==6">
	<Descuentos></Descuentos>	
</template>

