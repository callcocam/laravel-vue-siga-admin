
export function generateRoutes() {
    let routers = [];
    let data = window.menus;

    data.map(rote=>{
        routers.push({
            name:rote.name,
            path:rote.path,
            component:()=>import("@views/admin/AbstractPage"),
            redirect:{
                name:rote.redirect
            },
            meta:rote.meta,
            children:[
                {
                    name:rote.children.list.name,
                    path:rote.children.list.path,
                    component:()=>import("@views/admin/AbstractList"),
                    meta:rote.children.list.meta
                },
                {
                    name:rote.children.create.name,
                    path:rote.children.create.path,
                    component:()=>import("@views/admin/AbstractForm"),
                    meta:rote.children.create.meta
                },
                {

                    name:rote.children.edit.name,
                    path:rote.children.edit.path,
                    component:()=>import("@views/admin/AbstractForm"),
                    meta:rote.children.edit.meta
                },
                {

                    name:rote.children.show.name,
                    path:rote.children.show.path,
                    component:()=>import("@views/admin/AbstractShow"),
                    meta:rote.children.show.meta
                }
            ]
        })
    })

    return routers
}
