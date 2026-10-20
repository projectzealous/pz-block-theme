const fs=require('fs'),postcss=require('postcss');
const [,,inp,scope,out]=process.argv;
let css=fs.readFileSync(inp,'utf8');
const S='.'+scope;
const root=postcss.parse(css);
root.walkRules(r=>{
  let p=r.parent; while(p){ if(p.type==='atrule'&&/keyframes$/.test(p.name)) return; p=p.parent; }
  r.selectors=r.selectors.map(sel=>{
    sel=sel.trim();
    if(/\.pg(?![\w-])/.test(sel)) return sel.replace(/\.pg(?![\w-])/g,S);
    if(/^(html|body|:root)(?![\w-])/.test(sel)) return sel.replace(/^(html|body|:root)/,S);
    return S+' '+sel;
  });
});
fs.writeFileSync(out,'/* Lifted unchanged from the Study Mind Block Library design; only scoped under '+S+'. Do not edit by hand: regenerate from the design. */\n'+root.toString());
