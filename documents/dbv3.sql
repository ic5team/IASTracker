--
-- PostgreSQL database dump
--

-- Dumped from database version 9.4.4
-- Dumped by pg_dump version 9.4.4
-- Started on 2015-07-27 12:46:34

SET statement_timeout = 0;
SET lock_timeout = 0;
SET client_encoding = 'UTF8';
SET standard_conforming_strings = on;
SET check_function_bodies = false;
SET client_min_messages = warning;

--
-- TOC entry 213 (class 3079 OID 11855)
-- Name: plpgsql; Type: EXTENSION; Schema: -; Owner: 
--

CREATE EXTENSION IF NOT EXISTS plpgsql WITH SCHEMA pg_catalog;


--
-- TOC entry 2275 (class 0 OID 0)
-- Dependencies: 213
-- Name: EXTENSION plpgsql; Type: COMMENT; Schema: -; Owner: 
--

COMMENT ON EXTENSION plpgsql IS 'PL/pgSQL procedural language';


SET search_path = public, pg_catalog;

SET default_tablespace = '';

SET default_with_oids = false;

--
-- TOC entry 177 (class 1259 OID 26635)
-- Name: CRS; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "CRS" (
    id integer NOT NULL,
    code character varying(255) NOT NULL,
    proj4def character varying(255) NOT NULL,
    origin character varying(255) NOT NULL,
    transformation character varying(255) NOT NULL,
    scales character varying(255) NOT NULL,
    resolutions character varying(255) NOT NULL,
    bounds character varying(255) NOT NULL,
    "creatorId" integer,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE "CRS" OWNER TO iastracker;

--
-- TOC entry 176 (class 1259 OID 26633)
-- Name: CRS_id_seq; Type: SEQUENCE; Schema: public; Owner: iastracker
--

CREATE SEQUENCE "CRS_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "CRS_id_seq" OWNER TO iastracker;

--
-- TOC entry 2276 (class 0 OID 0)
-- Dependencies: 176
-- Name: CRS_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iastracker
--

ALTER SEQUENCE "CRS_id_seq" OWNED BY "CRS".id;


--
-- TOC entry 181 (class 1259 OID 26657)
-- Name: Grid10x10; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "Grid10x10" (
    id integer NOT NULL,
    "creatorId" integer,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE "Grid10x10" OWNER TO iastracker;

--
-- TOC entry 180 (class 1259 OID 26655)
-- Name: Grid10x10_id_seq; Type: SEQUENCE; Schema: public; Owner: iastracker
--

CREATE SEQUENCE "Grid10x10_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "Grid10x10_id_seq" OWNER TO iastracker;

--
-- TOC entry 2277 (class 0 OID 0)
-- Dependencies: 180
-- Name: Grid10x10_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iastracker
--

ALTER SEQUENCE "Grid10x10_id_seq" OWNED BY "Grid10x10".id;


--
-- TOC entry 187 (class 1259 OID 26687)
-- Name: IAS; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "IAS" (
    id integer NOT NULL,
    "latinName" character varying(255) NOT NULL,
    "taxonId" integer NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL,
    "creatorId" integer,
    deleted_at timestamp without time zone
);


ALTER TABLE "IAS" OWNER TO iastracker;

--
-- TOC entry 193 (class 1259 OID 26717)
-- Name: IASDescriptions; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "IASDescriptions" (
    id integer NOT NULL,
    "IASId" integer NOT NULL,
    "languageId" integer NOT NULL,
    name character varying(255) NOT NULL,
    "shortDescription" text NOT NULL,
    "longDescription" text NOT NULL,
    "creatorId" integer,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE "IASDescriptions" OWNER TO iastracker;

--
-- TOC entry 192 (class 1259 OID 26715)
-- Name: IASDescriptions_id_seq; Type: SEQUENCE; Schema: public; Owner: iastracker
--

CREATE SEQUENCE "IASDescriptions_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "IASDescriptions_id_seq" OWNER TO iastracker;

--
-- TOC entry 2278 (class 0 OID 0)
-- Dependencies: 192
-- Name: IASDescriptions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iastracker
--

ALTER SEQUENCE "IASDescriptions_id_seq" OWNED BY "IASDescriptions".id;


--
-- TOC entry 185 (class 1259 OID 26676)
-- Name: IASImages; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "IASImages" (
    id integer NOT NULL,
    "IASId" integer NOT NULL,
    "URL" character varying(255) NOT NULL,
    attribution text NOT NULL,
    "creatorId" integer,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE "IASImages" OWNER TO iastracker;

--
-- TOC entry 183 (class 1259 OID 26665)
-- Name: IASImagesTexts; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "IASImagesTexts" (
    id integer NOT NULL,
    "IASIId" integer NOT NULL,
    "languageId" integer NOT NULL,
    text text NOT NULL,
    "creatorId" integer,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE "IASImagesTexts" OWNER TO iastracker;

--
-- TOC entry 182 (class 1259 OID 26663)
-- Name: IASImagesTexts_id_seq; Type: SEQUENCE; Schema: public; Owner: iastracker
--

CREATE SEQUENCE "IASImagesTexts_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "IASImagesTexts_id_seq" OWNER TO iastracker;

--
-- TOC entry 2279 (class 0 OID 0)
-- Dependencies: 182
-- Name: IASImagesTexts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iastracker
--

ALTER SEQUENCE "IASImagesTexts_id_seq" OWNED BY "IASImagesTexts".id;


--
-- TOC entry 184 (class 1259 OID 26674)
-- Name: IASImages_id_seq; Type: SEQUENCE; Schema: public; Owner: iastracker
--

CREATE SEQUENCE "IASImages_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "IASImages_id_seq" OWNER TO iastracker;

--
-- TOC entry 2280 (class 0 OID 0)
-- Dependencies: 184
-- Name: IASImages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iastracker
--

ALTER SEQUENCE "IASImages_id_seq" OWNED BY "IASImages".id;


--
-- TOC entry 195 (class 1259 OID 26728)
-- Name: IASRegions; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "IASRegions" (
    id integer NOT NULL,
    "IASId" integer NOT NULL,
    "regionId" integer NOT NULL,
    "creatorId" integer,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE "IASRegions" OWNER TO iastracker;

--
-- TOC entry 203 (class 1259 OID 26766)
-- Name: IASRegionsValidators; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "IASRegionsValidators" (
    id integer NOT NULL,
    "IASRId" integer NOT NULL,
    "validatorId" integer NOT NULL,
    "creatorId" integer,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE "IASRegionsValidators" OWNER TO iastracker;

--
-- TOC entry 202 (class 1259 OID 26764)
-- Name: IASRegionsValidators_id_seq; Type: SEQUENCE; Schema: public; Owner: iastracker
--

CREATE SEQUENCE "IASRegionsValidators_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "IASRegionsValidators_id_seq" OWNER TO iastracker;

--
-- TOC entry 2281 (class 0 OID 0)
-- Dependencies: 202
-- Name: IASRegionsValidators_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iastracker
--

ALTER SEQUENCE "IASRegionsValidators_id_seq" OWNED BY "IASRegionsValidators".id;


--
-- TOC entry 194 (class 1259 OID 26726)
-- Name: IASRegions_id_seq; Type: SEQUENCE; Schema: public; Owner: iastracker
--

CREATE SEQUENCE "IASRegions_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "IASRegions_id_seq" OWNER TO iastracker;

--
-- TOC entry 2282 (class 0 OID 0)
-- Dependencies: 194
-- Name: IASRegions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iastracker
--

ALTER SEQUENCE "IASRegions_id_seq" OWNED BY "IASRegions".id;


--
-- TOC entry 191 (class 1259 OID 26706)
-- Name: IASRelatedDBs; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "IASRelatedDBs" (
    id integer NOT NULL,
    "repoId" integer NOT NULL,
    "IASId" integer NOT NULL,
    "URL" character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    "creatorId" integer,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE "IASRelatedDBs" OWNER TO iastracker;

--
-- TOC entry 190 (class 1259 OID 26704)
-- Name: IASRelatedDBs_id_seq; Type: SEQUENCE; Schema: public; Owner: iastracker
--

CREATE SEQUENCE "IASRelatedDBs_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "IASRelatedDBs_id_seq" OWNER TO iastracker;

--
-- TOC entry 2283 (class 0 OID 0)
-- Dependencies: 190
-- Name: IASRelatedDBs_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iastracker
--

ALTER SEQUENCE "IASRelatedDBs_id_seq" OWNED BY "IASRelatedDBs".id;


--
-- TOC entry 199 (class 1259 OID 26747)
-- Name: IASTaxons; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "IASTaxons" (
    id integer NOT NULL,
    "languageId" integer NOT NULL,
    name character varying(255) NOT NULL,
    "parentTaxonId" integer,
    "creatorId" integer,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE "IASTaxons" OWNER TO iastracker;

--
-- TOC entry 198 (class 1259 OID 26745)
-- Name: IASTaxons_id_seq; Type: SEQUENCE; Schema: public; Owner: iastracker
--

CREATE SEQUENCE "IASTaxons_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "IASTaxons_id_seq" OWNER TO iastracker;

--
-- TOC entry 2284 (class 0 OID 0)
-- Dependencies: 198
-- Name: IASTaxons_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iastracker
--

ALTER SEQUENCE "IASTaxons_id_seq" OWNED BY "IASTaxons".id;


--
-- TOC entry 186 (class 1259 OID 26685)
-- Name: IAS_id_seq; Type: SEQUENCE; Schema: public; Owner: iastracker
--

CREATE SEQUENCE "IAS_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "IAS_id_seq" OWNER TO iastracker;

--
-- TOC entry 2285 (class 0 OID 0)
-- Dependencies: 186
-- Name: IAS_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iastracker
--

ALTER SEQUENCE "IAS_id_seq" OWNED BY "IAS".id;


--
-- TOC entry 179 (class 1259 OID 26646)
-- Name: Languages; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "Languages" (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    "flagURL" character varying(255) NOT NULL,
    "creatorId" integer,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL,
    deleted_at timestamp without time zone
);


ALTER TABLE "Languages" OWNER TO iastracker;

--
-- TOC entry 178 (class 1259 OID 26644)
-- Name: Languages_id_seq; Type: SEQUENCE; Schema: public; Owner: iastracker
--

CREATE SEQUENCE "Languages_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "Languages_id_seq" OWNER TO iastracker;

--
-- TOC entry 2286 (class 0 OID 0)
-- Dependencies: 178
-- Name: Languages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iastracker
--

ALTER SEQUENCE "Languages_id_seq" OWNED BY "Languages".id;


--
-- TOC entry 174 (class 1259 OID 26616)
-- Name: MapProvider; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "MapProvider" (
    id integer NOT NULL,
    url character varying(255) NOT NULL,
    attribution text,
    description text,
    "zIndex" integer,
    "SWBoundLat" numeric(9,6),
    "SWBoundLon" numeric(9,6),
    "NEBoundLat" numeric(9,6),
    "NEBoundLon" numeric(9,6),
    "minZoom" integer NOT NULL,
    "maxZoom" integer NOT NULL,
    "creatorId" integer,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE "MapProvider" OWNER TO iastracker;

--
-- TOC entry 173 (class 1259 OID 26614)
-- Name: MapProvider_id_seq; Type: SEQUENCE; Schema: public; Owner: iastracker
--

CREATE SEQUENCE "MapProvider_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "MapProvider_id_seq" OWNER TO iastracker;

--
-- TOC entry 2287 (class 0 OID 0)
-- Dependencies: 173
-- Name: MapProvider_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iastracker
--

ALTER SEQUENCE "MapProvider_id_seq" OWNED BY "MapProvider".id;


--
-- TOC entry 205 (class 1259 OID 26774)
-- Name: ObservationImages; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "ObservationImages" (
    id integer NOT NULL,
    "observationId" integer NOT NULL,
    "URL" character varying(255) NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE "ObservationImages" OWNER TO iastracker;

--
-- TOC entry 204 (class 1259 OID 26772)
-- Name: ObservationImages_id_seq; Type: SEQUENCE; Schema: public; Owner: iastracker
--

CREATE SEQUENCE "ObservationImages_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "ObservationImages_id_seq" OWNER TO iastracker;

--
-- TOC entry 2288 (class 0 OID 0)
-- Dependencies: 204
-- Name: ObservationImages_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iastracker
--

ALTER SEQUENCE "ObservationImages_id_seq" OWNED BY "ObservationImages".id;


--
-- TOC entry 201 (class 1259 OID 26755)
-- Name: Observations; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "Observations" (
    id integer NOT NULL,
    "IASId" integer NOT NULL,
    "userId" integer NOT NULL,
    "languageId" integer NOT NULL,
    "validatorId" integer,
    "statusId" integer NOT NULL,
    notes text NOT NULL,
    "validatorTS" timestamp without time zone NOT NULL,
    latitude numeric(9,6) NOT NULL,
    longitude numeric(9,6) NOT NULL,
    elevation numeric(6,2) NOT NULL,
    accuracy numeric(6,2) NOT NULL,
    "thumbsUp" integer NOT NULL,
    "thumbsDown" integer NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE "Observations" OWNER TO iastracker;

--
-- TOC entry 200 (class 1259 OID 26753)
-- Name: Observations_id_seq; Type: SEQUENCE; Schema: public; Owner: iastracker
--

CREATE SEQUENCE "Observations_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "Observations_id_seq" OWNER TO iastracker;

--
-- TOC entry 2289 (class 0 OID 0)
-- Dependencies: 200
-- Name: Observations_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iastracker
--

ALTER SEQUENCE "Observations_id_seq" OWNED BY "Observations".id;


--
-- TOC entry 197 (class 1259 OID 26736)
-- Name: Regions; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "Regions" (
    id integer NOT NULL,
    "shapeFileURL" character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    "parentRegionId" integer,
    "creatorId" integer,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE "Regions" OWNER TO iastracker;

--
-- TOC entry 196 (class 1259 OID 26734)
-- Name: Regions_id_seq; Type: SEQUENCE; Schema: public; Owner: iastracker
--

CREATE SEQUENCE "Regions_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "Regions_id_seq" OWNER TO iastracker;

--
-- TOC entry 2290 (class 0 OID 0)
-- Dependencies: 196
-- Name: Regions_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iastracker
--

ALTER SEQUENCE "Regions_id_seq" OWNED BY "Regions".id;


--
-- TOC entry 189 (class 1259 OID 26695)
-- Name: Repositories; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "Repositories" (
    id integer NOT NULL,
    name character varying(255) NOT NULL,
    "URL" character varying(255) NOT NULL,
    "creatorId" integer,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE "Repositories" OWNER TO iastracker;

--
-- TOC entry 188 (class 1259 OID 26693)
-- Name: Repositories_id_seq; Type: SEQUENCE; Schema: public; Owner: iastracker
--

CREATE SEQUENCE "Repositories_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "Repositories_id_seq" OWNER TO iastracker;

--
-- TOC entry 2291 (class 0 OID 0)
-- Dependencies: 188
-- Name: Repositories_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iastracker
--

ALTER SEQUENCE "Repositories_id_seq" OWNED BY "Repositories".id;


--
-- TOC entry 207 (class 1259 OID 26782)
-- Name: Status; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "Status" (
    id integer NOT NULL,
    icon character varying(255) NOT NULL,
    "creatorId" integer,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE "Status" OWNER TO iastracker;

--
-- TOC entry 209 (class 1259 OID 26790)
-- Name: StatusTexts; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "StatusTexts" (
    id integer NOT NULL,
    "statusId" integer NOT NULL,
    "languageId" integer NOT NULL,
    text text NOT NULL,
    "creatorId" integer,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE "StatusTexts" OWNER TO iastracker;

--
-- TOC entry 208 (class 1259 OID 26788)
-- Name: StatusTexts_id_seq; Type: SEQUENCE; Schema: public; Owner: iastracker
--

CREATE SEQUENCE "StatusTexts_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "StatusTexts_id_seq" OWNER TO iastracker;

--
-- TOC entry 2292 (class 0 OID 0)
-- Dependencies: 208
-- Name: StatusTexts_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iastracker
--

ALTER SEQUENCE "StatusTexts_id_seq" OWNED BY "StatusTexts".id;


--
-- TOC entry 206 (class 1259 OID 26780)
-- Name: Status_id_seq; Type: SEQUENCE; Schema: public; Owner: iastracker
--

CREATE SEQUENCE "Status_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "Status_id_seq" OWNER TO iastracker;

--
-- TOC entry 2293 (class 0 OID 0)
-- Dependencies: 206
-- Name: Status_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iastracker
--

ALTER SEQUENCE "Status_id_seq" OWNED BY "Status".id;


--
-- TOC entry 212 (class 1259 OID 26806)
-- Name: Users; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "Users" (
    id integer NOT NULL,
    "languageId" integer NOT NULL,
    username character varying(255) NOT NULL,
    password character varying(255) NOT NULL,
    mail character varying(255) NOT NULL,
    name character varying(255) NOT NULL,
    "middleName" character varying(255) NOT NULL,
    "lastName" character varying(255) NOT NULL,
    "isActive" boolean NOT NULL,
    "activationKey" character varying(255) NOT NULL,
    "photoURL" character varying(255) NOT NULL,
    remember_token character varying(100),
    "amIExpert" boolean NOT NULL,
    "isExpert" boolean NOT NULL,
    "lastConnection" timestamp without time zone NOT NULL,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL,
    deleted_at timestamp without time zone
);


ALTER TABLE "Users" OWNER TO iastracker;

--
-- TOC entry 211 (class 1259 OID 26804)
-- Name: Users_id_seq; Type: SEQUENCE; Schema: public; Owner: iastracker
--

CREATE SEQUENCE "Users_id_seq"
    START WITH 1
    INCREMENT BY 1
    NO MINVALUE
    NO MAXVALUE
    CACHE 1;


ALTER TABLE "Users_id_seq" OWNER TO iastracker;

--
-- TOC entry 2294 (class 0 OID 0)
-- Dependencies: 211
-- Name: Users_id_seq; Type: SEQUENCE OWNED BY; Schema: public; Owner: iastracker
--

ALTER SEQUENCE "Users_id_seq" OWNED BY "Users".id;


--
-- TOC entry 210 (class 1259 OID 26799)
-- Name: Validators; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "Validators" (
    "userId" integer NOT NULL,
    organization character varying(255) NOT NULL,
    "creatorId" integer,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE "Validators" OWNER TO iastracker;

--
-- TOC entry 175 (class 1259 OID 26625)
-- Name: WMSMapProvider; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE "WMSMapProvider" (
    "mapProviderId" integer NOT NULL,
    layers character varying(255) NOT NULL,
    format character varying(255) NOT NULL,
    transparent boolean NOT NULL,
    "continuousWorld" boolean NOT NULL,
    "CRSId" integer,
    created_at timestamp without time zone NOT NULL,
    updated_at timestamp without time zone NOT NULL
);


ALTER TABLE "WMSMapProvider" OWNER TO iastracker;

--
-- TOC entry 172 (class 1259 OID 26611)
-- Name: migrations; Type: TABLE; Schema: public; Owner: iastracker; Tablespace: 
--

CREATE TABLE migrations (
    migration character varying(255) NOT NULL,
    batch integer NOT NULL
);


ALTER TABLE migrations OWNER TO iastracker;

--
-- TOC entry 2015 (class 2604 OID 26638)
-- Name: id; Type: DEFAULT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "CRS" ALTER COLUMN id SET DEFAULT nextval('"CRS_id_seq"'::regclass);


--
-- TOC entry 2017 (class 2604 OID 26660)
-- Name: id; Type: DEFAULT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Grid10x10" ALTER COLUMN id SET DEFAULT nextval('"Grid10x10_id_seq"'::regclass);


--
-- TOC entry 2020 (class 2604 OID 26690)
-- Name: id; Type: DEFAULT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IAS" ALTER COLUMN id SET DEFAULT nextval('"IAS_id_seq"'::regclass);


--
-- TOC entry 2023 (class 2604 OID 26720)
-- Name: id; Type: DEFAULT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASDescriptions" ALTER COLUMN id SET DEFAULT nextval('"IASDescriptions_id_seq"'::regclass);


--
-- TOC entry 2019 (class 2604 OID 26679)
-- Name: id; Type: DEFAULT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASImages" ALTER COLUMN id SET DEFAULT nextval('"IASImages_id_seq"'::regclass);


--
-- TOC entry 2018 (class 2604 OID 26668)
-- Name: id; Type: DEFAULT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASImagesTexts" ALTER COLUMN id SET DEFAULT nextval('"IASImagesTexts_id_seq"'::regclass);


--
-- TOC entry 2024 (class 2604 OID 26731)
-- Name: id; Type: DEFAULT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASRegions" ALTER COLUMN id SET DEFAULT nextval('"IASRegions_id_seq"'::regclass);


--
-- TOC entry 2028 (class 2604 OID 26769)
-- Name: id; Type: DEFAULT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASRegionsValidators" ALTER COLUMN id SET DEFAULT nextval('"IASRegionsValidators_id_seq"'::regclass);


--
-- TOC entry 2022 (class 2604 OID 26709)
-- Name: id; Type: DEFAULT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASRelatedDBs" ALTER COLUMN id SET DEFAULT nextval('"IASRelatedDBs_id_seq"'::regclass);


--
-- TOC entry 2026 (class 2604 OID 26750)
-- Name: id; Type: DEFAULT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASTaxons" ALTER COLUMN id SET DEFAULT nextval('"IASTaxons_id_seq"'::regclass);


--
-- TOC entry 2016 (class 2604 OID 26649)
-- Name: id; Type: DEFAULT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Languages" ALTER COLUMN id SET DEFAULT nextval('"Languages_id_seq"'::regclass);


--
-- TOC entry 2014 (class 2604 OID 26619)
-- Name: id; Type: DEFAULT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "MapProvider" ALTER COLUMN id SET DEFAULT nextval('"MapProvider_id_seq"'::regclass);


--
-- TOC entry 2029 (class 2604 OID 26777)
-- Name: id; Type: DEFAULT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "ObservationImages" ALTER COLUMN id SET DEFAULT nextval('"ObservationImages_id_seq"'::regclass);


--
-- TOC entry 2027 (class 2604 OID 26758)
-- Name: id; Type: DEFAULT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Observations" ALTER COLUMN id SET DEFAULT nextval('"Observations_id_seq"'::regclass);


--
-- TOC entry 2025 (class 2604 OID 26739)
-- Name: id; Type: DEFAULT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Regions" ALTER COLUMN id SET DEFAULT nextval('"Regions_id_seq"'::regclass);


--
-- TOC entry 2021 (class 2604 OID 26698)
-- Name: id; Type: DEFAULT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Repositories" ALTER COLUMN id SET DEFAULT nextval('"Repositories_id_seq"'::regclass);


--
-- TOC entry 2030 (class 2604 OID 26785)
-- Name: id; Type: DEFAULT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Status" ALTER COLUMN id SET DEFAULT nextval('"Status_id_seq"'::regclass);


--
-- TOC entry 2031 (class 2604 OID 26793)
-- Name: id; Type: DEFAULT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "StatusTexts" ALTER COLUMN id SET DEFAULT nextval('"StatusTexts_id_seq"'::regclass);


--
-- TOC entry 2032 (class 2604 OID 26809)
-- Name: id; Type: DEFAULT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Users" ALTER COLUMN id SET DEFAULT nextval('"Users_id_seq"'::regclass);


--
-- TOC entry 2232 (class 0 OID 26635)
-- Dependencies: 177
-- Data for Name: CRS; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "CRS" (id, code, proj4def, origin, transformation, scales, resolutions, bounds, "creatorId", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2295 (class 0 OID 0)
-- Dependencies: 176
-- Name: CRS_id_seq; Type: SEQUENCE SET; Schema: public; Owner: iastracker
--

SELECT pg_catalog.setval('"CRS_id_seq"', 1, false);


--
-- TOC entry 2236 (class 0 OID 26657)
-- Dependencies: 181
-- Data for Name: Grid10x10; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "Grid10x10" (id, "creatorId", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2296 (class 0 OID 0)
-- Dependencies: 180
-- Name: Grid10x10_id_seq; Type: SEQUENCE SET; Schema: public; Owner: iastracker
--

SELECT pg_catalog.setval('"Grid10x10_id_seq"', 1, false);


--
-- TOC entry 2242 (class 0 OID 26687)
-- Dependencies: 187
-- Data for Name: IAS; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "IAS" (id, "latinName", "taxonId", created_at, updated_at, "creatorId", deleted_at) FROM stdin;
\.


--
-- TOC entry 2248 (class 0 OID 26717)
-- Dependencies: 193
-- Data for Name: IASDescriptions; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "IASDescriptions" (id, "IASId", "languageId", name, "shortDescription", "longDescription", "creatorId", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2297 (class 0 OID 0)
-- Dependencies: 192
-- Name: IASDescriptions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: iastracker
--

SELECT pg_catalog.setval('"IASDescriptions_id_seq"', 1, false);


--
-- TOC entry 2240 (class 0 OID 26676)
-- Dependencies: 185
-- Data for Name: IASImages; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "IASImages" (id, "IASId", "URL", attribution, "creatorId", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2238 (class 0 OID 26665)
-- Dependencies: 183
-- Data for Name: IASImagesTexts; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "IASImagesTexts" (id, "IASIId", "languageId", text, "creatorId", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2298 (class 0 OID 0)
-- Dependencies: 182
-- Name: IASImagesTexts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: iastracker
--

SELECT pg_catalog.setval('"IASImagesTexts_id_seq"', 1, false);


--
-- TOC entry 2299 (class 0 OID 0)
-- Dependencies: 184
-- Name: IASImages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: iastracker
--

SELECT pg_catalog.setval('"IASImages_id_seq"', 1, false);


--
-- TOC entry 2250 (class 0 OID 26728)
-- Dependencies: 195
-- Data for Name: IASRegions; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "IASRegions" (id, "IASId", "regionId", "creatorId", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2258 (class 0 OID 26766)
-- Dependencies: 203
-- Data for Name: IASRegionsValidators; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "IASRegionsValidators" (id, "IASRId", "validatorId", "creatorId", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2300 (class 0 OID 0)
-- Dependencies: 202
-- Name: IASRegionsValidators_id_seq; Type: SEQUENCE SET; Schema: public; Owner: iastracker
--

SELECT pg_catalog.setval('"IASRegionsValidators_id_seq"', 1, false);


--
-- TOC entry 2301 (class 0 OID 0)
-- Dependencies: 194
-- Name: IASRegions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: iastracker
--

SELECT pg_catalog.setval('"IASRegions_id_seq"', 1, false);


--
-- TOC entry 2246 (class 0 OID 26706)
-- Dependencies: 191
-- Data for Name: IASRelatedDBs; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "IASRelatedDBs" (id, "repoId", "IASId", "URL", name, "creatorId", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2302 (class 0 OID 0)
-- Dependencies: 190
-- Name: IASRelatedDBs_id_seq; Type: SEQUENCE SET; Schema: public; Owner: iastracker
--

SELECT pg_catalog.setval('"IASRelatedDBs_id_seq"', 1, false);


--
-- TOC entry 2254 (class 0 OID 26747)
-- Dependencies: 199
-- Data for Name: IASTaxons; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "IASTaxons" (id, "languageId", name, "parentTaxonId", "creatorId", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2303 (class 0 OID 0)
-- Dependencies: 198
-- Name: IASTaxons_id_seq; Type: SEQUENCE SET; Schema: public; Owner: iastracker
--

SELECT pg_catalog.setval('"IASTaxons_id_seq"', 1, false);


--
-- TOC entry 2304 (class 0 OID 0)
-- Dependencies: 186
-- Name: IAS_id_seq; Type: SEQUENCE SET; Schema: public; Owner: iastracker
--

SELECT pg_catalog.setval('"IAS_id_seq"', 1, false);


--
-- TOC entry 2234 (class 0 OID 26646)
-- Dependencies: 179
-- Data for Name: Languages; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "Languages" (id, name, "flagURL", "creatorId", created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- TOC entry 2305 (class 0 OID 0)
-- Dependencies: 178
-- Name: Languages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: iastracker
--

SELECT pg_catalog.setval('"Languages_id_seq"', 1, false);


--
-- TOC entry 2229 (class 0 OID 26616)
-- Dependencies: 174
-- Data for Name: MapProvider; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "MapProvider" (id, url, attribution, description, "zIndex", "SWBoundLat", "SWBoundLon", "NEBoundLat", "NEBoundLon", "minZoom", "maxZoom", "creatorId", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2306 (class 0 OID 0)
-- Dependencies: 173
-- Name: MapProvider_id_seq; Type: SEQUENCE SET; Schema: public; Owner: iastracker
--

SELECT pg_catalog.setval('"MapProvider_id_seq"', 1, false);


--
-- TOC entry 2260 (class 0 OID 26774)
-- Dependencies: 205
-- Data for Name: ObservationImages; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "ObservationImages" (id, "observationId", "URL", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2307 (class 0 OID 0)
-- Dependencies: 204
-- Name: ObservationImages_id_seq; Type: SEQUENCE SET; Schema: public; Owner: iastracker
--

SELECT pg_catalog.setval('"ObservationImages_id_seq"', 1, false);


--
-- TOC entry 2256 (class 0 OID 26755)
-- Dependencies: 201
-- Data for Name: Observations; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "Observations" (id, "IASId", "userId", "languageId", "validatorId", "statusId", notes, "validatorTS", latitude, longitude, elevation, accuracy, "thumbsUp", "thumbsDown", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2308 (class 0 OID 0)
-- Dependencies: 200
-- Name: Observations_id_seq; Type: SEQUENCE SET; Schema: public; Owner: iastracker
--

SELECT pg_catalog.setval('"Observations_id_seq"', 1, false);


--
-- TOC entry 2252 (class 0 OID 26736)
-- Dependencies: 197
-- Data for Name: Regions; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "Regions" (id, "shapeFileURL", name, "parentRegionId", "creatorId", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2309 (class 0 OID 0)
-- Dependencies: 196
-- Name: Regions_id_seq; Type: SEQUENCE SET; Schema: public; Owner: iastracker
--

SELECT pg_catalog.setval('"Regions_id_seq"', 1, false);


--
-- TOC entry 2244 (class 0 OID 26695)
-- Dependencies: 189
-- Data for Name: Repositories; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "Repositories" (id, name, "URL", "creatorId", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2310 (class 0 OID 0)
-- Dependencies: 188
-- Name: Repositories_id_seq; Type: SEQUENCE SET; Schema: public; Owner: iastracker
--

SELECT pg_catalog.setval('"Repositories_id_seq"', 1, false);


--
-- TOC entry 2262 (class 0 OID 26782)
-- Dependencies: 207
-- Data for Name: Status; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "Status" (id, icon, "creatorId", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2264 (class 0 OID 26790)
-- Dependencies: 209
-- Data for Name: StatusTexts; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "StatusTexts" (id, "statusId", "languageId", text, "creatorId", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2311 (class 0 OID 0)
-- Dependencies: 208
-- Name: StatusTexts_id_seq; Type: SEQUENCE SET; Schema: public; Owner: iastracker
--

SELECT pg_catalog.setval('"StatusTexts_id_seq"', 1, false);


--
-- TOC entry 2312 (class 0 OID 0)
-- Dependencies: 206
-- Name: Status_id_seq; Type: SEQUENCE SET; Schema: public; Owner: iastracker
--

SELECT pg_catalog.setval('"Status_id_seq"', 1, false);


--
-- TOC entry 2267 (class 0 OID 26806)
-- Dependencies: 212
-- Data for Name: Users; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "Users" (id, "languageId", username, password, mail, name, "middleName", "lastName", "isActive", "activationKey", "photoURL", remember_token, "amIExpert", "isExpert", "lastConnection", created_at, updated_at, deleted_at) FROM stdin;
\.


--
-- TOC entry 2313 (class 0 OID 0)
-- Dependencies: 211
-- Name: Users_id_seq; Type: SEQUENCE SET; Schema: public; Owner: iastracker
--

SELECT pg_catalog.setval('"Users_id_seq"', 1, false);


--
-- TOC entry 2265 (class 0 OID 26799)
-- Dependencies: 210
-- Data for Name: Validators; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "Validators" ("userId", organization, "creatorId", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2230 (class 0 OID 26625)
-- Dependencies: 175
-- Data for Name: WMSMapProvider; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY "WMSMapProvider" ("mapProviderId", layers, format, transparent, "continuousWorld", "CRSId", created_at, updated_at) FROM stdin;
\.


--
-- TOC entry 2227 (class 0 OID 26611)
-- Dependencies: 172
-- Data for Name: migrations; Type: TABLE DATA; Schema: public; Owner: iastracker
--

COPY migrations (migration, batch) FROM stdin;
2015_07_24_140706_inicial	1
2015_07_24_174442_createForeignKeys	1
\.


--
-- TOC entry 2038 (class 2606 OID 26643)
-- Name: CRS_pkey; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "CRS"
    ADD CONSTRAINT "CRS_pkey" PRIMARY KEY (id);


--
-- TOC entry 2042 (class 2606 OID 26662)
-- Name: Grid10x10_pkey; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "Grid10x10"
    ADD CONSTRAINT "Grid10x10_pkey" PRIMARY KEY (id);


--
-- TOC entry 2054 (class 2606 OID 26725)
-- Name: IASDescriptions_pkey; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "IASDescriptions"
    ADD CONSTRAINT "IASDescriptions_pkey" PRIMARY KEY (id);


--
-- TOC entry 2044 (class 2606 OID 26673)
-- Name: IASImagesTexts_pkey; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "IASImagesTexts"
    ADD CONSTRAINT "IASImagesTexts_pkey" PRIMARY KEY (id);


--
-- TOC entry 2046 (class 2606 OID 26684)
-- Name: IASImages_pkey; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "IASImages"
    ADD CONSTRAINT "IASImages_pkey" PRIMARY KEY (id);


--
-- TOC entry 2064 (class 2606 OID 26771)
-- Name: IASRegionsValidators_pkey; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "IASRegionsValidators"
    ADD CONSTRAINT "IASRegionsValidators_pkey" PRIMARY KEY (id);


--
-- TOC entry 2056 (class 2606 OID 26733)
-- Name: IASRegions_pkey; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "IASRegions"
    ADD CONSTRAINT "IASRegions_pkey" PRIMARY KEY (id);


--
-- TOC entry 2052 (class 2606 OID 26714)
-- Name: IASRelatedDBs_pkey; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "IASRelatedDBs"
    ADD CONSTRAINT "IASRelatedDBs_pkey" PRIMARY KEY (id);


--
-- TOC entry 2060 (class 2606 OID 26752)
-- Name: IASTaxons_pkey; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "IASTaxons"
    ADD CONSTRAINT "IASTaxons_pkey" PRIMARY KEY (id);


--
-- TOC entry 2048 (class 2606 OID 26692)
-- Name: IAS_pkey; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "IAS"
    ADD CONSTRAINT "IAS_pkey" PRIMARY KEY (id);


--
-- TOC entry 2040 (class 2606 OID 26654)
-- Name: Languages_pkey; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "Languages"
    ADD CONSTRAINT "Languages_pkey" PRIMARY KEY (id);


--
-- TOC entry 2034 (class 2606 OID 26624)
-- Name: MapProvider_pkey; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "MapProvider"
    ADD CONSTRAINT "MapProvider_pkey" PRIMARY KEY (id);


--
-- TOC entry 2066 (class 2606 OID 26779)
-- Name: ObservationImages_pkey; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "ObservationImages"
    ADD CONSTRAINT "ObservationImages_pkey" PRIMARY KEY (id);


--
-- TOC entry 2062 (class 2606 OID 26763)
-- Name: Observations_pkey; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "Observations"
    ADD CONSTRAINT "Observations_pkey" PRIMARY KEY (id);


--
-- TOC entry 2058 (class 2606 OID 26744)
-- Name: Regions_pkey; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "Regions"
    ADD CONSTRAINT "Regions_pkey" PRIMARY KEY (id);


--
-- TOC entry 2050 (class 2606 OID 26703)
-- Name: Repositories_pkey; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "Repositories"
    ADD CONSTRAINT "Repositories_pkey" PRIMARY KEY (id);


--
-- TOC entry 2070 (class 2606 OID 26798)
-- Name: StatusTexts_pkey; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "StatusTexts"
    ADD CONSTRAINT "StatusTexts_pkey" PRIMARY KEY (id);


--
-- TOC entry 2068 (class 2606 OID 26787)
-- Name: Status_pkey; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "Status"
    ADD CONSTRAINT "Status_pkey" PRIMARY KEY (id);


--
-- TOC entry 2074 (class 2606 OID 26814)
-- Name: Users_pkey; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "Users"
    ADD CONSTRAINT "Users_pkey" PRIMARY KEY (id);


--
-- TOC entry 2072 (class 2606 OID 26803)
-- Name: validators_userid_unique; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "Validators"
    ADD CONSTRAINT validators_userid_unique UNIQUE ("userId");


--
-- TOC entry 2036 (class 2606 OID 26632)
-- Name: wmsmapprovider_mapproviderid_unique; Type: CONSTRAINT; Schema: public; Owner: iastracker; Tablespace: 
--

ALTER TABLE ONLY "WMSMapProvider"
    ADD CONSTRAINT wmsmapprovider_mapproviderid_unique UNIQUE ("mapProviderId");


--
-- TOC entry 2078 (class 2606 OID 26830)
-- Name: crs_creatorid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "CRS"
    ADD CONSTRAINT crs_creatorid_foreign FOREIGN KEY ("creatorId") REFERENCES "Users"(id) ON DELETE CASCADE;


--
-- TOC entry 2080 (class 2606 OID 26840)
-- Name: grid10x10_creatorid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Grid10x10"
    ADD CONSTRAINT grid10x10_creatorid_foreign FOREIGN KEY ("creatorId") REFERENCES "Users"(id) ON DELETE CASCADE;


--
-- TOC entry 2087 (class 2606 OID 26875)
-- Name: ias_creatorid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IAS"
    ADD CONSTRAINT ias_creatorid_foreign FOREIGN KEY ("creatorId") REFERENCES "Users"(id) ON DELETE CASCADE;


--
-- TOC entry 2086 (class 2606 OID 26870)
-- Name: ias_taxonid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IAS"
    ADD CONSTRAINT ias_taxonid_foreign FOREIGN KEY ("taxonId") REFERENCES "IASTaxons"(id) ON DELETE CASCADE;


--
-- TOC entry 2094 (class 2606 OID 26910)
-- Name: iasdescriptions_creatorid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASDescriptions"
    ADD CONSTRAINT iasdescriptions_creatorid_foreign FOREIGN KEY ("creatorId") REFERENCES "Users"(id) ON DELETE CASCADE;


--
-- TOC entry 2092 (class 2606 OID 26900)
-- Name: iasdescriptions_iasid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASDescriptions"
    ADD CONSTRAINT iasdescriptions_iasid_foreign FOREIGN KEY ("IASId") REFERENCES "IAS"(id) ON DELETE CASCADE;


--
-- TOC entry 2093 (class 2606 OID 26905)
-- Name: iasdescriptions_languageid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASDescriptions"
    ADD CONSTRAINT iasdescriptions_languageid_foreign FOREIGN KEY ("languageId") REFERENCES "Languages"(id) ON DELETE CASCADE;


--
-- TOC entry 2085 (class 2606 OID 26865)
-- Name: iasimages_creatorid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASImages"
    ADD CONSTRAINT iasimages_creatorid_foreign FOREIGN KEY ("creatorId") REFERENCES "Users"(id) ON DELETE CASCADE;


--
-- TOC entry 2084 (class 2606 OID 26860)
-- Name: iasimages_iasid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASImages"
    ADD CONSTRAINT iasimages_iasid_foreign FOREIGN KEY ("IASId") REFERENCES "IAS"(id) ON DELETE CASCADE;


--
-- TOC entry 2083 (class 2606 OID 26855)
-- Name: iasimagestexts_creatorid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASImagesTexts"
    ADD CONSTRAINT iasimagestexts_creatorid_foreign FOREIGN KEY ("creatorId") REFERENCES "Users"(id) ON DELETE CASCADE;


--
-- TOC entry 2081 (class 2606 OID 26845)
-- Name: iasimagestexts_iasiid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASImagesTexts"
    ADD CONSTRAINT iasimagestexts_iasiid_foreign FOREIGN KEY ("IASIId") REFERENCES "IASImages"(id) ON DELETE CASCADE;


--
-- TOC entry 2082 (class 2606 OID 26850)
-- Name: iasimagestexts_languageid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASImagesTexts"
    ADD CONSTRAINT iasimagestexts_languageid_foreign FOREIGN KEY ("languageId") REFERENCES "Languages"(id) ON DELETE CASCADE;


--
-- TOC entry 2097 (class 2606 OID 26925)
-- Name: iasregions_creatorid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASRegions"
    ADD CONSTRAINT iasregions_creatorid_foreign FOREIGN KEY ("creatorId") REFERENCES "Users"(id) ON DELETE CASCADE;


--
-- TOC entry 2095 (class 2606 OID 26915)
-- Name: iasregions_iasid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASRegions"
    ADD CONSTRAINT iasregions_iasid_foreign FOREIGN KEY ("IASId") REFERENCES "IAS"(id) ON DELETE CASCADE;


--
-- TOC entry 2096 (class 2606 OID 26920)
-- Name: iasregions_regionid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASRegions"
    ADD CONSTRAINT iasregions_regionid_foreign FOREIGN KEY ("regionId") REFERENCES "Regions"(id) ON DELETE CASCADE;


--
-- TOC entry 2109 (class 2606 OID 26985)
-- Name: iasregionsvalidators_creatorid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASRegionsValidators"
    ADD CONSTRAINT iasregionsvalidators_creatorid_foreign FOREIGN KEY ("creatorId") REFERENCES "Users"(id) ON DELETE CASCADE;


--
-- TOC entry 2107 (class 2606 OID 26975)
-- Name: iasregionsvalidators_iasrid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASRegionsValidators"
    ADD CONSTRAINT iasregionsvalidators_iasrid_foreign FOREIGN KEY ("IASRId") REFERENCES "IASRegions"(id) ON DELETE CASCADE;


--
-- TOC entry 2108 (class 2606 OID 26980)
-- Name: iasregionsvalidators_validatorid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASRegionsValidators"
    ADD CONSTRAINT iasregionsvalidators_validatorid_foreign FOREIGN KEY ("validatorId") REFERENCES "Validators"("userId") ON DELETE CASCADE;


--
-- TOC entry 2091 (class 2606 OID 26895)
-- Name: iasrelateddbs_creatorid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASRelatedDBs"
    ADD CONSTRAINT iasrelateddbs_creatorid_foreign FOREIGN KEY ("creatorId") REFERENCES "Users"(id) ON DELETE CASCADE;


--
-- TOC entry 2090 (class 2606 OID 26890)
-- Name: iasrelateddbs_iasid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASRelatedDBs"
    ADD CONSTRAINT iasrelateddbs_iasid_foreign FOREIGN KEY ("IASId") REFERENCES "IAS"(id);


--
-- TOC entry 2089 (class 2606 OID 26885)
-- Name: iasrelateddbs_repoid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASRelatedDBs"
    ADD CONSTRAINT iasrelateddbs_repoid_foreign FOREIGN KEY ("repoId") REFERENCES "Repositories"(id) ON DELETE CASCADE;


--
-- TOC entry 2101 (class 2606 OID 26945)
-- Name: iastaxons_creatorid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASTaxons"
    ADD CONSTRAINT iastaxons_creatorid_foreign FOREIGN KEY ("creatorId") REFERENCES "Users"(id) ON DELETE CASCADE;


--
-- TOC entry 2100 (class 2606 OID 26940)
-- Name: iastaxons_languageid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASTaxons"
    ADD CONSTRAINT iastaxons_languageid_foreign FOREIGN KEY ("languageId") REFERENCES "Languages"(id) ON DELETE CASCADE;


--
-- TOC entry 2099 (class 2606 OID 26935)
-- Name: iastaxons_parenttaxonid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "IASTaxons"
    ADD CONSTRAINT iastaxons_parenttaxonid_foreign FOREIGN KEY ("parentTaxonId") REFERENCES "IASTaxons"(id);


--
-- TOC entry 2079 (class 2606 OID 26835)
-- Name: languages_creatorid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Languages"
    ADD CONSTRAINT languages_creatorid_foreign FOREIGN KEY ("creatorId") REFERENCES "Users"(id) ON DELETE CASCADE;


--
-- TOC entry 2075 (class 2606 OID 26815)
-- Name: mapprovider_creatorid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "MapProvider"
    ADD CONSTRAINT mapprovider_creatorid_foreign FOREIGN KEY ("creatorId") REFERENCES "Users"(id) ON DELETE CASCADE;


--
-- TOC entry 2110 (class 2606 OID 26990)
-- Name: observationimages_observationid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "ObservationImages"
    ADD CONSTRAINT observationimages_observationid_foreign FOREIGN KEY ("observationId") REFERENCES "Observations"(id) ON DELETE CASCADE;


--
-- TOC entry 2102 (class 2606 OID 26950)
-- Name: observations_iasid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Observations"
    ADD CONSTRAINT observations_iasid_foreign FOREIGN KEY ("IASId") REFERENCES "IAS"(id);


--
-- TOC entry 2104 (class 2606 OID 26960)
-- Name: observations_languageid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Observations"
    ADD CONSTRAINT observations_languageid_foreign FOREIGN KEY ("languageId") REFERENCES "Languages"(id) ON DELETE CASCADE;


--
-- TOC entry 2106 (class 2606 OID 26970)
-- Name: observations_statusid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Observations"
    ADD CONSTRAINT observations_statusid_foreign FOREIGN KEY ("statusId") REFERENCES "Status"(id) ON DELETE CASCADE;


--
-- TOC entry 2103 (class 2606 OID 26955)
-- Name: observations_userid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Observations"
    ADD CONSTRAINT observations_userid_foreign FOREIGN KEY ("userId") REFERENCES "Users"(id) ON DELETE CASCADE;


--
-- TOC entry 2105 (class 2606 OID 26965)
-- Name: observations_validatorid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Observations"
    ADD CONSTRAINT observations_validatorid_foreign FOREIGN KEY ("validatorId") REFERENCES "Validators"("userId") ON DELETE SET NULL;


--
-- TOC entry 2098 (class 2606 OID 26930)
-- Name: regions_creatorid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Regions"
    ADD CONSTRAINT regions_creatorid_foreign FOREIGN KEY ("creatorId") REFERENCES "Users"(id) ON DELETE CASCADE;


--
-- TOC entry 2088 (class 2606 OID 26880)
-- Name: repositories_creatorid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Repositories"
    ADD CONSTRAINT repositories_creatorid_foreign FOREIGN KEY ("creatorId") REFERENCES "Users"(id) ON DELETE CASCADE;


--
-- TOC entry 2111 (class 2606 OID 26995)
-- Name: status_creatorid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Status"
    ADD CONSTRAINT status_creatorid_foreign FOREIGN KEY ("creatorId") REFERENCES "Users"(id) ON DELETE CASCADE;


--
-- TOC entry 2114 (class 2606 OID 27010)
-- Name: statustexts_creatorid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "StatusTexts"
    ADD CONSTRAINT statustexts_creatorid_foreign FOREIGN KEY ("creatorId") REFERENCES "Users"(id) ON DELETE CASCADE;


--
-- TOC entry 2113 (class 2606 OID 27005)
-- Name: statustexts_languageid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "StatusTexts"
    ADD CONSTRAINT statustexts_languageid_foreign FOREIGN KEY ("languageId") REFERENCES "Languages"(id) ON DELETE CASCADE;


--
-- TOC entry 2112 (class 2606 OID 27000)
-- Name: statustexts_statusid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "StatusTexts"
    ADD CONSTRAINT statustexts_statusid_foreign FOREIGN KEY ("statusId") REFERENCES "Status"(id) ON DELETE CASCADE;


--
-- TOC entry 2117 (class 2606 OID 27025)
-- Name: users_languageid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Users"
    ADD CONSTRAINT users_languageid_foreign FOREIGN KEY ("languageId") REFERENCES "Languages"(id) ON DELETE CASCADE;


--
-- TOC entry 2116 (class 2606 OID 27020)
-- Name: validators_creatorid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Validators"
    ADD CONSTRAINT validators_creatorid_foreign FOREIGN KEY ("creatorId") REFERENCES "Users"(id) ON DELETE CASCADE;


--
-- TOC entry 2115 (class 2606 OID 27015)
-- Name: validators_userid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "Validators"
    ADD CONSTRAINT validators_userid_foreign FOREIGN KEY ("userId") REFERENCES "Users"(id) ON DELETE CASCADE;


--
-- TOC entry 2077 (class 2606 OID 26825)
-- Name: wmsmapprovider_crsid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "WMSMapProvider"
    ADD CONSTRAINT wmsmapprovider_crsid_foreign FOREIGN KEY ("CRSId") REFERENCES "CRS"(id) ON DELETE CASCADE;


--
-- TOC entry 2076 (class 2606 OID 26820)
-- Name: wmsmapprovider_mapproviderid_foreign; Type: FK CONSTRAINT; Schema: public; Owner: iastracker
--

ALTER TABLE ONLY "WMSMapProvider"
    ADD CONSTRAINT wmsmapprovider_mapproviderid_foreign FOREIGN KEY ("mapProviderId") REFERENCES "MapProvider"(id) ON DELETE CASCADE;


--
-- TOC entry 2274 (class 0 OID 0)
-- Dependencies: 5
-- Name: public; Type: ACL; Schema: -; Owner: postgres
--

REVOKE ALL ON SCHEMA public FROM PUBLIC;
REVOKE ALL ON SCHEMA public FROM postgres;
GRANT ALL ON SCHEMA public TO postgres;
GRANT ALL ON SCHEMA public TO PUBLIC;


-- Completed on 2015-07-27 12:46:35

--
-- PostgreSQL database dump complete
--

