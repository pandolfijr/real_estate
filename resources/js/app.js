import { createApp } from "vue";
import { createRouter, createWebHistory } from "vue-router";
import VueTheMask from "vue-the-mask";
import VueSweetalert2 from "vue-sweetalert2";
import "sweetalert2/dist/sweetalert2.min.css";
import money from "v-money3";

const Home = () => import("./components/dashboards/Home.vue");
const Pagination = () => import("./components/dashboards/Pagination.vue");
const MenuSite = () => import("./components/site/Menu.vue");
// const ModalProperties = () => import("./components/dashboards/property/ModalProperties.vue");
const PropertiesList = () => import("./components/dashboards/property/PropertiesList.vue");
const Property = () => import("./components/dashboards/property/Property.vue");
const TransactionsList = () => import("./components/dashboards/transaction/TransactionsList.vue");
const Transaction = () => import("./components/dashboards/transaction/Transaction.vue");
const CondosList = () => import("./components/dashboards/condo/CondosList.vue");
const Condo = () => import("./components/dashboards/condo/Condo.vue");
const SuppliersList = () => import("./components/dashboards/supplier/SuppliersList.vue");
const Supplier = () => import("./components/dashboards/supplier/Supplier.vue");
const BankAccountsList = () => import("./components/dashboards/bank-account/BankAccountsList.vue");
const BankAccount = () => import("./components/dashboards/bank-account/BankAccount.vue");
const ChecksList = () => import("./components/dashboards/check/ChecksList.vue");
const Check = () => import("./components/dashboards/check/Check.vue");
const CashFlowList = () => import("./components/dashboards/cashflow/CashFlowList.vue");
const CashFlow = () => import("./components/dashboards/cashflow/CashFlow.vue");
const AccountsPayList = () => import("./components/dashboards/account-pay/AccountsPayList.vue");
const AccountPay = () => import("./components/dashboards/account-pay/AccountPay.vue");
const Installment = () => import("./components/dashboards/installment/Installment.vue");
const InstallmentsList = () => import("./components/dashboards/installment/InstallmentsList.vue");
const PayOffAccountPay = () => import("./components/dashboards/account-pay/PayOffAccountPay.vue");
const TransfersList = () => import("./components/dashboards/transfer/TransfersList.vue");
const PayOffTransfer = () => import("./components/dashboards/transfer/PayOffTransfer.vue");
const AccountsReceiveList = () => import("./components/dashboards/account-receive/AccountsReceiveList.vue");
const AccountReceive = () => import("./components/dashboards/account-receive/AccountReceive.vue");
const PayOffAccountReceive = () => import("./components/dashboards/account-receive/PayOffAccountReceive.vue");
const PayOffInstallment = () => import("./components/dashboards/installment/PayOffInstallment.vue");
const LocatorsList = () => import("./components/dashboards/locator/LocatorsList.vue");
const Locator = () => import("./components/dashboards/locator/Locator.vue");
const RentersList = () => import("./components/dashboards/renter/RentersList.vue");
const Renter = () => import("./components/dashboards/renter/Renter.vue");
const GuarantorsList = () => import("./components/dashboards/guarantor/GuarantorsList.vue");
const Guarantor = () => import("./components/dashboards/guarantor/Guarantor.vue");
const SettingList = () => import("./components/dashboards/setting/SettingList.vue");
const Setting = () => import("./components/dashboards/setting/Setting.vue");
const CitiesList = () => import("./components/dashboards/city/CitiesList.vue");
const City = () => import("./components/dashboards/city/City.vue");
const ReportsList = () => import("./components/dashboards/report/ReportsList.vue");
const User = () => import("./components/dashboards/user/User.vue");
const UserEditTypeUser = () => import("./components/dashboards/user/UserEditTypeUser.vue");
const UsersList = () => import("./components/dashboards/user/UsersList.vue");
const Welcome = () => import("./components/site/Welcome.vue");
const About = () => import("./components/site/About.vue");
const AllProperties = () => import("./components/site/AllProperties.vue");
const PropertyDetails = () => import("./components/site/PropertyDetails.vue");
const Search = () => import("./components/dashboards/Search.vue");
const Footer = () => import("./components/site/Footer.vue");
const SearchSite = () => import("./components/site/Search.vue");

// Cria uma instância do aplicativo Vue
const app = createApp({
    devtools: true,
});

//  ######################  INICIO ROTAS ######################

app.component("pagination", Pagination);
app.component("menu-site", MenuSite);
app.component("search", Search);
app.component("footer-site", Footer);
app.component("search-site", SearchSite);

const routes = [
    { path: "/", name: "Welcome", component: Welcome },
    { path: "/about", name: "About", component: About },
    {
        path: "/all_properties",
        name: "AllProperties",
        component: AllProperties,
    },
    {
        path: "/property_details/:id",
        name: "PropertyDetails",
        component: PropertyDetails,
    },
    { path: "/home", name: "Home", component: Home },
    // {
    //     path: "/modal-properties",
    //     name: "ModalProperties",
    //     component: ModalProperties,
    // },

    // ####################### User #######################
    { path: "/users-list", name: "UsersList", component: UsersList },
    // { path: "/user/:id/edit", name: "User", component: User },
    { path: "/user/:id/edit_user", name: "User", component: UserEditTypeUser },
    { path: "/user/create", name: "CreateUser", component: User },
    { path: "/user/edit/:id", name: "User", component: User },
    // ####################### End User #######################

    // ####################### City #######################
    { path: "/cities-list", name: "CitiesList", component: CitiesList },
    { path: "/city/:id/edit", name: "City", component: City },
    { path: "/city/create", name: "CreateCity", component: City },
    // ####################### End City #######################

    // ####################### Property #######################
    {
        path: "/properties-list",
        name: "PropertiesList",
        component: PropertiesList,
    },
    { path: "/property/:id/edit", name: "Property", component: Property },
    { path: "/property/create", name: "CreateProperty", component: Property },
    // ####################### End Property #######################

    // ####################### Transaction #######################
    {
        path: "/transactions-list",
        name: "TransactionsList",
        component: TransactionsList,
    },
    {
        path: "/transaction/:id/edit",
        name: "Transaction",
        component: Transaction,
    },
    {
        path: "/transaction/create",
        name: "CreateTransaction",
        component: Transaction,
    },
    // ####################### End Transaction #######################

    // ####################### Condo #######################
    { path: "/condos-list", name: "CondosList", component: CondosList },
    { path: "/condo/:id/edit", name: "Condo", component: Condo },
    { path: "/condo/create", name: "CreateCondo", component: Condo },
    // ####################### End Condo #######################

    // ####################### Supplier #######################
    {
        path: "/suppliers-list",
        name: "SuppliersList",
        component: SuppliersList,
    },
    { path: "/supplier/:id/edit", name: "Supplier", component: Supplier },
    { path: "/supplier/create", name: "CreateSupplier", component: Supplier },
    // ####################### End Supplier #######################

    // ####################### BankAccount #######################
    {
        path: "/bank-accounts-list",
        name: "BankAccountsList",
        component: BankAccountsList,
    },
    {
        path: "/bank-account/:id/edit",
        name: "BankAccount",
        component: BankAccount,
    },
    {
        path: "/bank-account/create",
        name: "CreateBankAccount",
        component: BankAccount,
    },
    // ####################### End BankAccount #######################

    // ####################### CashFlow #######################
    { path: "/cashflow-list", name: "CashFlowList", component: CashFlowList },
    { path: "/cashflow/:id/edit", name: "CashFlow", component: CashFlow },
    // ####################### End BankAccount #######################

    // ####################### ToPay #######################
    {
        path: "/accounts-pay-list",
        name: "AccountsPayList",
        component: AccountsPayList,
    },
    {
        path: "/account-pay/:id/edit",
        name: "AccountPay",
        component: AccountPay,
    },
    {
        path: "/account-pay/:id/pay-off",
        name: "PayOffAccountPay",
        component: PayOffAccountPay,
    },
    {
        path: "/account-pay/create",
        name: "CreateAccountPay",
        component: AccountPay,
    },
    // ####################### End ToPay #######################


     // ####################### Installment #######################
     {
        path: "/installments-list",
        name: "InstallmentsList",
        component: InstallmentsList,
    },
    {
        path: "/installment/:id/edit",
        name: "Installment",
        component: Installment,
    },
    {
        path: "/installment/:id/pay-off",
        name: "PayOffInstallment",
        component: PayOffInstallment,
    },
    {
        path: "/installment/create",
        name: "CreateInstallment",
        component: Installment,
    },
    // ####################### End Installment #######################


    // ####################### Transfers #######################
    {
        path: "/transfers-list",
        name: "TransfersList",
        component: TransfersList,
    },
    {
        path: "/transfer/:id/pay-off",
        name: "PayOffTransfer",
        component: PayOffTransfer,
    },

    // ####################### End Transfers #######################


    // ####################### ToReceive #######################
    {
        path: "/accounts-receive-list",
        name: "AccountsReceiveList",
        component: AccountsReceiveList,
    },
    {
        path: "/account-receive/:id/edit",
        name: "AccountReceive",
        component: AccountReceive,
    },
    {
        path: "/account-receive/create",
        name: "CreateAccountReceive",
        component: AccountReceive,
    },
    {
        path: "/account-receive/:id/pay-off",
        name: "PayOffAccountReceive",
        component: PayOffAccountReceive,
    },


    // ####################### End ToReceive #######################

    // ####################### Check #######################
    { path: "/checks-list", name: "ChecksList", component: ChecksList },
    { path: "/check/:id/edit", name: "Check", component: Check },
    { path: "/check/create", name: "CreateCheck", component: Check },
    // ####################### End Check #######################

    // ####################### Locator #######################

    { path: "/locators-list", name: "LocatorsList", component: LocatorsList },
    { path: "/locator/:id/edit", name: "Locator", component: Locator },
    { path: "/locator/create", name: "CreateLocator", component: Locator },

    // ####################### End Locator #######################

    // ####################### Renter #######################
    { path: "/renters-list", name: "RentersList", component: RentersList },
    { path: "/renter/:id/edit", name: "Renter", component: Renter },
    { path: "/renter/create", name: "CreateRenter", component: Renter },
    // ####################### End Renter #######################

    // ####################### Guarantor #######################
    {
        path: "/guarantors-list",
        name: "GuarantorsList",
        component: GuarantorsList,
    },
    { path: "/guarantor/:id/edit", name: "Guarantor", component: Guarantor },
    {
        path: "/guarantor/create",
        name: "CreateGuarantor",
        component: Guarantor,
    },
    // ####################### End Guarantor #######################

    // ####################### Report #######################
    { path: "/reports-list", name: "ReportsList", component: ReportsList },
    // ####################### End Report #######################

    // ####################### Setting #######################
    { path: "/setting-list", name: "SettingList", component: SettingList },
    { path: "/setting/:id/edit", name: "Setting", component: Setting },
    // ####################### End Setting #######################
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    scrollBehavior(to, from, savedPosition) {
        if (to.hash) {
          return {
            el: to.hash,
            behavior: 'smooth'
          };
        }
        return { top: 0 };
      }
});

app.use(VueTheMask);
app.use(VueSweetalert2);
app.use(money);
//  ######################  FIM ROTAS ######################

app.use(router);

app.mount("#app");
